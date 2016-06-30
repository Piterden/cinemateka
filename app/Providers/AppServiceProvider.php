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
        view()->share('events', \App\Models\Event::all()->toJson());
        view()->share('programs', \App\Models\Program::all()->toJson());
        view()->share('places', \App\Models\Place::all()->toJson());
        view()->share('categories', \App\Models\Category::all()->toJson());

        // view()->share('seances', \App\Models\Seance::all());

        // view()->share('programs', \App\Models\Program::with([
        //     'seances' => function ($query)
        //     {
        //         $query->orderBy('start_time');
        //     },
        // ])->get()->toJson());

        // view()->share('events', \App\Models\Event::with([
        //     'seances' => function ($query)
        //     {
        //         $query->orderBy('start_time');
        //     },
        // ])->get()->toJson());
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
