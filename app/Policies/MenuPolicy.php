<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role === 'staff';
    }

    public function update(User $user, Menu $menu)
    {
        return $user->role === 'staff';
    }

    public function delete(User $user, Menu $menu)
    {
        return $user->role === 'staff';
    }
}