<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Share collections to all views
         */

        view()->share('seances', \App\Models\Seance::all()->toJson());

        view()->share('categories', \App\Models\Category::all()->toJson());

        view()->share('events', \App\Models\Event::where([
            'published' => 1
        ])->get()->toJson());

        view()->share('programs', \App\Models\Program::where([
            'published' => 1
        ])->get()->toJson());

        view()->share('places', \App\Models\Place::where([
            'published' => 1
        ])->get()->toJson());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
