<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role === 'customer';
    }

    public function viewAny(User $user)
    {
        return $user->role === 'staff';
    }

    public function view(User $user, Order $order)
    {
        return $user->role === 'staff' || $user->id === $order->user_id;
    }
}