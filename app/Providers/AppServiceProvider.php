<?php

namespace App\Providers;

use App\Repository\BookRepo;
use App\Repository\UserRepo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BookRepo::class, BookRepo::class);
        $this->app->singleton(UserRepo::class, UserRepo::class);
    }
}
