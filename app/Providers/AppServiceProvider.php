<?php

namespace App\Providers;

use App\Models\DishCategory;
use App\Repositories\Interfaces\AppetizerRepositoryInterface;
use App\Repositories\Interfaces\DrinkRepositoryInterface;
use App\Repositories\AppetizerRepository;
use App\Repositories\DishCategoryRepository;
use App\Repositories\Interfaces\DishCategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DishCategoryRepositoryInterface::class, DishCategoryRepository::class);
        $this->app->bind(AppetizerRepositoryInterface::class, AppetizerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}