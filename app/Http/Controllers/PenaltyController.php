<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Penalty;
use App\Perpetrator;
use Auth;
use Illuminate\Http\Request;
use Log;

class PenaltyController extends Controller
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
        //

        return view('cases.penalty')->with(['id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
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
        $penalty = Penalty::find($id);

        return view('cases.penalty_edit')->with(['penalty' => $penalty]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
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

        return redirect()->back();
    }

    public function calculatePaidPenalties()
    {

        $perpetrators = Perpetrator::where('server', '=', 'com')->where('deleted_at', '=', '0000-00-00 00:00:00')->get();
        $handled_perpetrators_count = 0;
        $have_penalty = 0;
        $free = 0;
        $had_penalty = 0;
        $gold_paid = 0;
        $failed_lookup = 0;
        $free_people = array();
        foreach ($perpetrators as $p) {
            //Check if username is valid
            $check = file_get_contents('http://warofdragons.com/user_info.php?nick=' . urlencode($p->name));
            $not_exist = strpos($check, 'User not found!');
            if ($not_exist) {
                continue;
            }

            if ($p->penalty) {

                if ((1 === $p->penalty->currency) && ($p->penalty->fine > 0)) {

                    $s = file_get_contents('http://www.warofdragons.com/punishment_info.php?nick=' . urlencode($p->name));
                    if ($s) {
                        $try = strpos($s, 'This user is not under any curse!');
                        if ($try) {
                            // User has no Curses
                            ++$free;
                            $free_people[$p->name] = round(($p->penalty->fine/100), 0);
                            $gold_paid += $p->penalty->fine;
                        } else {
                            // User in in prison
                            ++$have_penalty;
                        }

                        ++$had_penalty;
                    } else {

                        ++$failed_lookup;

                    }


                } else {

                }

            } else {


            }

            ++$handled_perpetrators_count;
        }


        /* $s = file_get_contents('http://www.warofdragons.com/punishment_info.php?nick=' . $username);
        $try = strpos($s, 'This user is not under any curse!');
        if ($try) {
            echo 'User has no Curses';
        } else {
            echo 'User in in prison';
        } */

        //dd($free_people);
        $people = implode($free_people);
        return print 'Total: ' . $handled_perpetrators_count .
            ',<br /> Failed to check penalty: ' . $failed_lookup .
            ',<br /> Total with penalty in gold: ' . $had_penalty .
            ',<br /> With penalty in gold now: ' . $have_penalty .
            ',<br /> Freed: ' . $free .
            ',<br /> Fines paid in gold: ' . $gold_paid / 100 .
            ',<br /> Released people' . $people;
    }

}
