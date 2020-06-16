<?php

namespace App\Providers;

use App\Category;
use App\Client;
use App\Order;
use App\Policies\CategoryPolicy;
use App\Policies\ClientPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use App\Product;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class=>UserPolicy::class,
        Category::class=>CategoryPolicy::class,
        Product::class=>ProductPolicy::class,
        Client::class=>ClientPolicy::class,
        Order::class=>OrderPolicy::class,

        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
