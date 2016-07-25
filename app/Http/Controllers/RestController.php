<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class RestController extends Controller
{
	/**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function getMenu()
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }

}
