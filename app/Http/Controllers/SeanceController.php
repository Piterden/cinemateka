<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'start_time' => 'required',
            'event_id'   => 'required|alpha_num',
        ]);

        $statusCode = 200;
        try {
            $seance = Seance::create($request->all());
            $seance->save();
        }
        catch (Exception $e)
        {
            $statusCode = 400;
        }
        finally
        {
            return Response::json($seance, $statusCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $statusCode = 200;
        try {
            $seances = Seance::where('event_id', $id)->get();
        }
        catch (Exception $e)
        {
            $statusCode = 400;
        }
        finally
        {
            return Response::json($seances, $statusCode);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id'         => 'required|alpha_num',
            'start_time' => 'required',
            'event_id'   => 'required|alpha_num',
            'program_id' => 'alpha_num',
            'place_id'   => 'alpha_num',
        ]);

        $statusCode = 200;
        try {
            $seance = Seance::findOrFail($id);
            $seance->update($request->all());
            $seance->save();
        }
        catch (Exception $e)
        {
            $statusCode = 400;
        }
        finally
        {
            return Response::json($seance, $statusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $statusCode = 200;
        try {
            $seance = Seance::findOrFail($id);
            $seance->delete();
        }
        catch (Exception $e)
        {
            $statusCode = 400;
        }
        finally
        {
            return Response::json($seance, $statusCode);
        }
    }
}
