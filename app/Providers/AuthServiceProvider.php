<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Policies\MenuPolicy;
use App\Policies\UserPolicy;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Menu::class => MenuPolicy::class,
        User::class => UserPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}