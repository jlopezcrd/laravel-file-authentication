<?php

namespace Developez\LaraFileAuth\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Guard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
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

        Auth::provider('file', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            switch (config('auth.providers.custom.driver', 'json'))
            {
                case 'json':
                    return new AuthFileProvider(
                        $app->make('Developez\LaraFileAuth\Engine\JsonStorageEngine'),
                        $app['hash'],
                        config('auth.providers.custom.model', Cryptavel\User::class)
                    );
                    break;

                default:
                    return new AuthFileProvider(
                        $app->make('Developez\LaraFileAuth\Engine\ArrayStorageEngine'),
                        $app['hash'],
                        config('auth.providers.custom.model', Cryptavel\User::class)
                    );
                    break;
            }
        });
    }
}