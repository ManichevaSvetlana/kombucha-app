<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Account' => 'App\Policies\AccountPolicy',
        'App\NovaModels\Account' => 'App\Policies\AdminAccountPolicy',
        'App\NovaModels\User' => 'App\Policies\AdminUserPolicy',
        'App\Customer' => 'App\Policies\CustomerPolicy',
        'App\Product' => 'App\Policies\ProductPolicy',
        'App\Role' => 'App\Policies\RolePolicy',
        'App\Order' => 'App\Policies\OrderPolicy',
        'App\UserRole' => 'App\Policies\RolePolicy',
        'App\ForumCategory' => 'App\Policies\ForumCategoryPolicy',
        'App\ForumComment' => 'App\Policies\ForumCommentPolicy',
        'App\NovaModels\SalesRepresentative' => 'App\Policies\SalesRepresentativePolicy',
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
