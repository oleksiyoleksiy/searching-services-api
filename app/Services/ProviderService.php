<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProviderService
{
    public function __construct(private UserService $service) {
    }


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
                        $sub->where('weekday', now()->weekday())
                            ->where('start', '<=', now()->format('H:i'))
                            ->where('end', '>=', now()->format('H:i'));
                    } elseif (in_array('weekend', $availability)) {
                        $sub->whereIn('weekday', Carbon::getWeekendDays());
                    }
                });
            });
        }

        if ($ratings = request('rating')) {
            $thresholds = [];

            if (in_array('3plus', $ratings)) {
                $thresholds[] = 3;
            }

            if (in_array('4plus', $ratings)) {
                $thresholds[] = 4;
            }

            if (!empty($thresholds)) {
                $min = min($thresholds);

                $query->whereIn('companies.id', function ($subquery) use ($min) {
                    $subquery->select('company_id')
                        ->from('reviews')
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

            $avatar_remove = (bool) ($data['avatar_remove'] ?? false);

            $user = auth()->user();

            $this->updateCompany($user, $data);

            $user->update($data);

            $this->service->updateAvatar($user, $avatar, $avatar_remove);

            return $user->refresh();
        });
    }

    private function updateCompany(User $user, array $data)
    {
        $company = $user->company;

        $company->update([
            'name' => $data['company_name'],
            'years_of_experience' => $data['years_of_experience'],
            'description' => $data['company_description'],
        ]);

        $company->categories()->sync($data['categories']);
    }

    public function show(Company $company)
    {
        return $company->load(['reviews', 'services', 'availabilities', 'reviews']);
    }
}
