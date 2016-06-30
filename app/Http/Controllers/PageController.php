<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;

class PageController extends Controller
{

    public function staticPage()
    {
        return view('index');
    }

    public function listPage($page = 1)
    {
        return view('index');
    }

    public function entityPage($slug = false)
    {
        if (!$slug)
        {
            return $this->missingMethod(['slug' => false]);
        }

        return view('index');
    }

    public function missingMethod($parameters = [])
    {
        return view('index');
    }
}
