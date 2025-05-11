<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function update(array $data)
    {
        return DB::transaction(function () use ($data) {
            $avatar = data_get($data, 'avatar');

            $avatar_remove = $data['avatar_remove'];

            $user = auth()->user();

            unset($data['avatar']);

            $user->update($data);

            if ($avatar_remove) {
                $user->filesByType('avatar')->delete();
            }

            if ($avatar) {
                $user->filesByType('avatar')->delete();

                $path = $avatar->store('images');

                $user->files()->create([
                    'type' => 'avatar',
                    'path' => $path
                ]);
            }

            return $user->refresh();
        });
    }
}
