<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;

class PageController extends Controller
{
    // public $pageSize = 20;

    public function __construct(Request $request)
    {
        $events = \App\Models\Event::all();
        $events->load([
            'seances' => function ($query) {
                $query->orderBy('start_time');
            }
        ]);

        $programs = \App\Models\Program::all();
        $programs->load([
            'seances' => function ($query) {
                $query->orderBy('start_time');
            }
        ]);

        $seances = $events->map(function ($item) {
            return $item->seances;
        })->collapse();

        JavaScript::put([
            'events' => $events,
            'programs' => $programs,
            'seances' => $seances,
            'uri' => $request->path(),
            // 'places' => \App\Models\Place::all(),
        ]);
    }

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
        if (!$slug) {
            return $this->missingMethod(['slug' => false]);
        }

        JavaScript::put([
            'slug' => $slug,
        ]);

        return view('index');
    }

    public function missingMethod($parameters = array())
    {
        JavaScript::put([
            'missing' => true,
            'parameters' => $parameters,
        ]);

        return view('index');
    }
}
