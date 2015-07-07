<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Penalty;
use App\Perpetrator;
use Auth;
use Illuminate\Http\Request;
use Log;

class PenaltyController extends Controller
{
    public function create($id)
    {

        return view('cases.penalty')->with(['id' => $id]);
    }

    public function store(Request $request)
    {
        $penalty = new Penalty;
        $input = $request->all();
        $perpetrator = Perpetrator::find($input['perpetrator_id']);
        $penalty->type = $input['type'];
        $penalty->currency = $input['currency'];
        $penalty->fine = $input['fine'];
        $penalty->perpetrator_id = $perpetrator->id;
        $penalty->issued_by_id = Auth::user()->id;
        $penalty->server = Auth::user()->server;
        $penalty->case_id = $perpetrator->case_id;
        $penalty->save();

        return '<script>window.opener.location.reload(false); this.close();</script>';
    }

    public function edit($id)
    {
        $penalty = Penalty::find($id);

        return view('cases.penalty_edit')->with(['penalty' => $penalty]);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $penalty = Penalty::find($input['penalty_id']);
        $penalty->type = $input['type'];
        $penalty->currency = $input['currency'];
        $penalty->fine = $input['fine'];
        $penalty->issued_by_id = Auth::user()->id;
        $penalty->server = Auth::user()->server;
        $penalty->save();

        Log::info(Auth::user()->name . '(' . Auth::user()->server . ')  changed penalty (ID=' . $penalty->id . ').  Type: ' . $penalty->type . ', Currency: ' . $penalty->currency . ' Amount: ' . $penalty->fine);

        return '<script>window.opener.location.reload(false); this.close();</script>';

    }

    public function destroy($id)
    {
        $perpetrator = Perpetrator::find($id);
        $perpetrator->deleted_at = date("Y-m-d H:i:s", time());
        $perpetrator->save();

        Log::info(Auth::user()->name . '(' . Auth::user()->server . ')' . 'deleted perpetrator number ' . $perpetrator->id);

        return redirect()->back();
    }
}
