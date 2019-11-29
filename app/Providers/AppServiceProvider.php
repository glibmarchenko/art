<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Products\Picture;
use App\Models\Products\Poster;
use App\Models\Purchase;
use App\Observers\OrderObserver;
use App\Observers\PurchaseObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'poster' => Poster::class,
            'picture' => Picture::class,
        ]);

        Passport::routes();
        
        Purchase::observe(PurchaseObserver::class);
        Order::observe(OrderObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
