<?php
namespace App\Providers;

// use Cache;
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
        // $seances = Cache::remember('seances', 60, function ()
        // {
        //     return \App\Models\Seance::where('id', '>', 0)
        //     ->orderBy('start_time', 'asc')->get();
        // });

        // $categories = Cache::remember('categories', 60, function ()
        // {
        //     return \App\Models\Category::all();
        // });

        // $events = Cache::remember('events', 60, function ()
        // {
        //     return \App\Models\Event::where([
        //         'published' => '1',
        //     ])->get();
        // });

        // $programs = Cache::remember('programs', 60, function ()
        // {
        //     return \App\Models\Program::where([
        //         'published' => '1',
        //     ])->get();
        // });

        // $places = Cache::remember('places', 60, function ()
        // {
        //     return \App\Models\Place::where([
        //         'published' => '1',
        //     ])->get();
        // });

        // $slides = Cache::remember('slides', 60, function ()
        // {
        //     return \App\Models\Slide::where([
        //         'published' => '1',
        //     ])->get();
        // });

        /**
         * Share collections to all views
         */
        $seances = \App\Models\Seance::where('id', '>', 0)
            ->orderBy('start_time', 'asc')->get();

        $categories = \App\Models\Category::all();

        $events = \App\Models\Event::where([
            'published' => '1',
        ])->get();

        $programs = \App\Models\Program::where([
            'published' => '1',
        ])->get();

        $places = \App\Models\Place::where([
            'published' => '1',
        ])->get();

        $slides = \App\Models\Slide::where([
            'published' => '1',
        ])->get();

        view()->share('seances', $seances);
        view()->share('categories', $categories);
        view()->share('events', $events);
        view()->share('programs', $programs);
        view()->share('places', $places);
        view()->share('slides', $slides);
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
