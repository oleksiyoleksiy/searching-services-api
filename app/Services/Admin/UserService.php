<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Services\UserService as ServicesUserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(private ServicesUserService $userService) {}

    public function index(): LengthAwarePaginator
    {
        $query = User::whereNot('id', auth()->id());

        if ($search = request('search')) {
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
        }

        return $query->paginate(10);
    }

    public function store(array $data)
    {
        DB::transaction(function () use ($data) {
            $user = User::create($data);

            $isAdmin = (bool) $data['is_admin'];

            if ($isAdmin) {
                $user->assignRole('admin');
            }

            $avatar = data_get($data, 'avatar');

            $this->userService->updateAvatar($user, $avatar);
        });
    }

    public function update(array $data, User $user)
    {
        DB::transaction(function () use ($data, $user) {
            $avatar = data_get($data, 'avatar');

            $avatarRemove = (bool) ($data['avatar_remove'] ?? false);

            $isAdmin = (bool) $data['is_admin'];

            $isAdmin
            ? $user->assignRole('admin')
            : $user->removeRole('admin');

            $user->update($data);

            $this->userService->updateAvatar($user, $avatar, $avatarRemove);
        });
    }
}
