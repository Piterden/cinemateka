<?php
namespace App\Providers;

// use Cache;
use App\Models\Event;
use App\Models\Place;
use App\Models\Slide;
use App\Models\Seance;
use App\Models\Program;
use App\Models\Category;
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
        $seances = Seance::where('id', '>', 0)
        ->orderBy('start_time', 'asc')->get();

        $categories = Category::all();

        $events = Event::where([
            'published' => '1',
        ])->get();

        $programs = Program::where([
            'published' => '1',
        ])->get();

        $places = Place::where([
            'published' => '1',
        ])->get();

        $slides = Slide::where([
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
