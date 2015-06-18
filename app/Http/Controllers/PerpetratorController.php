<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Penalty;
use App\Perpetrator;
use Auth;
use Log;

use Illuminate\Http\Request;

class PerpetratorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $perpetrator = Perpetrator::find($id);

        return view('cases.perpetrator_delete')->with(['perpetrator' => $perpetrator]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update()
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $perpetrator = Perpetrator::find($id);
        $perpetrator->deleted_at = date("Y-m-d H:i:s", time());
        $perpetrator->save();

        Log::info(Auth::user()->name . '(' . Auth::user()->server . ')' . 'deleted perpetrator number ' . $perpetrator->id);

        return '<script>window.opener.location.reload(false); this.close();</script>';
    }

}
