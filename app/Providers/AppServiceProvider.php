<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Sanctum::authenticateAccessTokensUsing(
        //     static function (PersonalAccessToken $accessToken, bool $is_valid) {
        //         if (!$accessToken->can('read:limited')) {
        //             return $is_valid;
        //         }

        //         return $is_valid && $accessToken->created_at->gt(now()->subMinutes(1));
        //     }
        // );

        Sanctum::authenticateAccessTokensUsing(
            static function (PersonalAccessToken $accessToken, bool $is_valid) {
                // if (!$accessToken->can('read:limited')) {
                //     return $is_valid;
                // }

                return $accessToken->created_at->gt(now()->subMinutes(1));
            }
        );
    }
}
