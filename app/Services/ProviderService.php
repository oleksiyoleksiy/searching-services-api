<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProviderService
{
    public function indexByCategory(Category $category)
    {
        $query = $category->companies()->with(['reviews', 'services', 'availabilities']);

        $this->applyFilters($query);

        return $query->get();
    }

    public function index()
    {
        $query = Company::query()->with(['reviews', 'services', 'availabilities']);

        $this->applyFilters($query);

        return $query->get();
    }

    public function applyFilters(&$query)
    {
        if ($search = request('search')) {
            $query->where('name', 'LIKE', "%$search%");
        }

        if ($availability = request('availability')) {
            $query->whereHas('availabilities', function ($q) use ($availability) {
                $q->where(function ($sub) use ($availability) {
                    if (in_array('today', $availability)) {
                        $sub->where('day', now()->format('l'))
                            ->where('start', '<=', now()->format('H:i'))
                            ->where('end', '>=', now()->format('H:i'));
                    } elseif (in_array('weekend', $availability)) {
                        $sub->whereIn('day', ['Saturday', 'Sunday']);
                    }
                });
            });
        }

        if ($rating = request('rating')) {
            if (in_array($rating, ['3plus', '4plus'])) {
                $min = $rating === '3plus' ? 3 : 4;
                $query->whereHas('reviews', function ($q) use ($min) {
                    $q->selectRaw('company_id, AVG(rating) as avg_rating')
                        ->groupBy('company_id')
                        ->havingRaw('AVG(rating) >= ?', [$min]);
                });
            }
        }

        if ($priceRange = request('priceRange')) {
            $query->whereHas('services', function ($q) use ($priceRange) {
                if ($priceRange === 'low') {
                    $q->where('price', '<', 100);
                } elseif ($priceRange === 'medium') {
                    $q->whereBetween('price', [100, 300]);
                } elseif ($priceRange === 'high') {
                    $q->where('price', '>', 300);
                }
            });
        }
        if ($postalCode = request('postalCode')) {
            $query->whereHas('user', function ($q) use ($postalCode) {
                $q->where('postal_code', $postalCode);
            });
        }

        if ($limit = request('limit')) {
            $query->limit($limit);
        }
    }

    public function update(array $data)
    {
        return DB::transaction(function () use ($data) {
            $avatar = data_get($data, 'avatar');

            $avatar_remove = $data['avatar_remove'];

            $user = auth()->user();

            $this->updateCompany($user, $data);

            unset(
                $data['avatar'],
                $data['company_name'],
                $data['years_of_experience'],
                $data['company_description'],
                $data['categories']
            );

            $user->update($data);

            if ($avatar_remove) {
                $user->filesByType('avatar')->first()?->delete();
            }

            if ($avatar) {
                $user->filesByType('avatar')->first()?->delete();

                $path = $avatar->store('images');

                $user->files()->create([
                    'type' => 'avatar',
                    'path' => $path
                ]);
            }

            return $user->refresh();
        });
    }

    private function updateCompany(User $user, array $data)
    {
        $company = $user->company;

        $company->update([
            'name' => $data['company_name'],
            'years_of_experience' => $data['years_of_experience'],
            'company_description' => $data['company_description'],
        ]);

        $company->categories()->sync($data['categories']);
    }
}
