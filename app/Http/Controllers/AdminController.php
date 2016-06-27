<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class AdminController extends Controller
{
    public function upload()
    {
        $data = [];

        if (Request::hasFile('file')) {
            $data['result'] = Imageupload::upload(Request::file('file'));
            return response()->json(array('data'=> $data), 200);
        }

        return response()->json(false, 200);
    }
}
