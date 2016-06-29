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

        // view()->share('seances', \App\Models\Seance::all());

        view()->share('programs', \App\Models\Program::with([
            'seances' => function ($query)
            {
                $query->orderBy('start_time');
            },
        ])->get());

        view()->share('events', \App\Models\Event::with([
            'seances' => function ($query)
            {
                $query->orderBy('start_time');
            },
        ])->get());

        view()->share('places', \App\Models\Place::all());

        view()->share('categories', \App\Models\Category::all());
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
