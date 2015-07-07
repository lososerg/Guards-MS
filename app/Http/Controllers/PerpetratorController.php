<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Perpetrator;
use Auth;
use Log;

class PerpetratorController extends Controller
{

    public function edit($id)
    {
        $perpetrator = Perpetrator::find($id);

        return view('cases.perpetrator_delete')->with(['perpetrator' => $perpetrator]);
    }

    public function destroy($id)
    {
        $perpetrator = Perpetrator::find($id);
        $perpetrator->deleted_at = date("Y-m-d H:i:s", time());
        $perpetrator->save();

        Log::info(Auth::user()->name . '(' . Auth::user()->server . ')' . 'deleted perpetrator number ' . $perpetrator->id);

        return '<script>window.opener.location.reload(false); this.close();</script>';
    }

}
