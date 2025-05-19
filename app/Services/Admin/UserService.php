<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function index(): LengthAwarePaginator
    {
        return User::where('id', auth()->id())->paginate(10);
    }
}
