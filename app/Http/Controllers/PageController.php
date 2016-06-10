<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;

class PageController extends Controller
{
    public function index(Request $request)
    {
        JavaScript::put([
            'events' => \App\Models\Event::all(),
            'programs' => \App\Models\Program::all(),
            'uri' => $request->path(),
            // 'places' => \App\Models\Place::all(),
        ]);

        return view('index');
    }
}
