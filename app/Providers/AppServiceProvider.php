<?php

namespace App\Providers;

use App\Models\Contents;
use App\Models\Fleets;
use App\Models\Services;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('contacts', Contents::where('section','contact')->where('page', '/')->first());
        View::share('services', Services::all());
        View::share('fleets', Fleets::all());
    }
}
