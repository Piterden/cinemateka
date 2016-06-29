<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;

class PageController extends Controller
{
    // public $pageSize = 20;

    // public function __construct(Request $request)
    // {
    //     $events = \App\Models\Event::with([
    //         'seances' => function ($query)
    //         {
    //             $query->orderBy('start_time');
    //         },
    //     ])->get();

    //     $programs = \App\Models\Program::with([
    //         'seances' => function ($query)
    //         {
    //             $query->orderBy('start_time');
    //         },
    //     ])->get();

    //     JavaScript::put([
    //         'events'     => $events,
    //         'programs'   => $programs,
    //         'places'     => \App\Models\Place::all(),
    //         'categories' => \App\Models\Category::all(),
    //         'uri'        => $request->path(),
    //     ]);
    // }

    public function staticPage()
    {
        return view('index');
    }

    public function listPage($page = 1)
    {
        JavaScript::put([
            'page' => $page,
        ]);

        return view('index');
    }

    public function entityPage($slug = false)
    {
        if (!$slug)
        {
            return $this->missingMethod(['slug' => false]);
        }

        JavaScript::put([
            'slug' => $slug,
        ]);

        return view('index');
    }

    public function missingMethod($parameters = [])
    {
        JavaScript::put([
            'missing'    => true,
            'parameters' => $parameters,
        ]);

        return view('index');
    }
}
