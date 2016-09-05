<?php
namespace App\Http\Controllers;

use DB;
use App;
use URL;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        // create new sitemap object
        $sitemap = App::make('sitemap');
        $date    = new Carbon();

        $sitemap->setCache('laravel.sitemap', 3600);
        if (!$sitemap->isCached())
        {
            $sitemap->add(URL::to('/'), $date, '1.0', 'daily');
            $sitemap->add(URL::to('archive'), $date, '0.9', 'monthly');
            $sitemap->add(URL::to('schedule'), $date, '0.9', 'monthly');
            $sitemap->add(URL::to('contacts'), $date, '0.9', 'monthly');
            $sitemap->add(URL::to('about'), $date, '0.9', 'monthly');
            $sitemap->add(URL::to('partners'), $date, '0.9', 'monthly');

            $events = DB::table('events')->orderBy('created_at', 'desc')->get();
            foreach ($events as $event)
            {
                if ($slug = $event->slug && !$event->deleted_at)
                {
                    $sitemap->add(URL::to('event/'.$event->slug), $event->updated_at, '0.6', 'daily');
                }
            }

            $programs = DB::table('programs')->orderBy('created_at', 'desc')->get();
            foreach ($programs as $program)
            {
                if ($slug = $program->slug && !$program->deleted_at)
                {
                    $sitemap->add(URL::to('program/'.$program->slug), $program->updated_at, '0.6', 'daily');
                }
            }
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');

    }
}
