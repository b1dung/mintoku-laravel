<?php
namespace Mintoku\UserAuth;

use Illuminate\Support\ServiceProvider;

class UserAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__."/../routes/web.php");
        $this->loadViewsFrom(__DIR__."/../resources/views", "user-auth");
        
        $this->publishes([
            __DIR__."/../resources/css" => public_path("vendor/user-auth/css"),
            __DIR__."/../resources/js" => public_path("vendor/user-auth/js"),
        ], "user-auth-assets");
    }
}