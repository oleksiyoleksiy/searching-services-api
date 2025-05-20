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
            $user = auth()->user();

            $avatar = data_get($data, 'avatar');

            $avatarRemove = (bool) ($data['avatar_remove'] ?? false);

            $user->update($data);

            $this->updateAvatar($user, $avatar, $avatarRemove);

            return $user->refresh();
        });
    }

    public function updateAvatar(User $user, $avatar, bool $remove = false): void
    {
        if ($remove || $avatar) {
            $user->filesByType('avatar')->first()?->delete();
        }

        if ($avatar) {
            $path = $avatar->store('images');

            $user->files()->create([
                'type' => 'avatar',
                'path' => $path,
            ]);
        }
    }
}
