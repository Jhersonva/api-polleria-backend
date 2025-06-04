<?php

namespace App\Providers;

use App\Models\DishCategory;
use App\Models\Drink;
use App\Repositories\Interfaces\AppetizerRepositoryInterface;
use App\Repositories\Interfaces\DishRepositoryInterface;
use App\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use App\Repositories\AppetizerRepository;
use App\Repositories\DishCategoryRepository;
use App\Repositories\DishRepository;
use App\Repositories\DrinkRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\Interfaces\DishCategoryRepositoryInterface;
use App\Repositories\Interfaces\DrinkRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use PhpParser\Node\Scalar\MagicConst\Dir;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DishCategoryRepositoryInterface::class, DishCategoryRepository::class);
        $this->app->bind(AppetizerRepositoryInterface::class, AppetizerRepository::class);
        $this->app->bind(DishRepositoryInterface::class, DishRepository::class);
        $this->app->bind(DrinkRepositoryInterface::class, DrinkRepository::class);
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
