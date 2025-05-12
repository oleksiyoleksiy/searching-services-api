<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProviderService
{
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
            'years_of_experience' => $data['years_of_experience']
        ]);

        $company->categories()->sync($data['categories']);
    }
}
