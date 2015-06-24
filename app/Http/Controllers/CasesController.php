<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Cases;
use App\Perpetrator;
use App\Penalty;
use Auth;
use Log;
use DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class CasesController extends Controller
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function index()
    {

        if (5 == Auth::user()->department_id) { // Helpdesk department

            $cases = DB::table('cases')
                ->where('server', '=', Auth::user()->server)
                ->where('status', '<=', 2)
                ->where('department_id', '=', 5)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);

        } elseif (Auth::user()->helpdesk) {

            $cases = DB::table('cases')
                ->where('server', '=', Auth::user()->server)
                ->where('status', '<=', 2)
                ->where('race', '=', Auth::user()->race)
                ->where('department_id', '<', 5)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);

        } else { // All guards departments

            $cases = DB::table('cases')
                ->where('race', '=', Auth::user()->race)
                ->where('server', '=', Auth::user()->server)
                ->where('status', '<=', 2)
                ->where('department_id', '<', 5)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
        }

        return view('cases.all')->with(['cases' => $cases]);

    }

    public function loadClosedCases()
    {

        if (5 == Auth::user()->department_id) { // Helpdesk department

            $cases = DB::table('cases')
                ->where('server', '=', Auth::user()->server)
                ->where('status', '=', 3)
                ->where('department_id', '=', 5)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);

        } elseif (Auth::user()->helpdesk) {

            $cases = DB::table('cases')
                ->where('server', '=', Auth::user()->server)
                ->where('status', '=', 3)
                ->where('department_id', '<=', 5)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);

        } else { // All guards departments

            $cases = DB::table('cases')
                ->where('race', '=', Auth::user()->race)
                ->where('server', '=', Auth::user()->server)
                ->where('status', '=', 3)
                ->where('department_id', '<', 5)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);

        }

        return view('cases.all')->with(['cases' => $cases]);

    }

    public function load($id)
    {

        if (!Cases::find($id)) {
            return redirect('home');
        }

        $case = Cases::find($id);

        if ((Auth::user()->server != $case->server) or ((Auth::user()->department_id == 5) and ($case->department_id < 5))) {

            return redirect('home');

        }

        $guards = UserController::loadUsersAsArray();
        $perpetrators = $case->perpetrators;
        /*if (Auth::user()->admin == 2) {
        dd($perpetrators);
        }*/


        Log::info(Auth::user()->name . '(' . Auth::user()->server . ')' . ' looks at case number ' . $case->id);


        return view('cases.one')
            ->with(['case' => $case])
            ->with(['guards' => $guards])
            ->with(['perpetrators' => $perpetrators]);

    }

    public function store(Request $request)
    {

        $this->validate($request, ['description' => 'max:40000']);
        $case = new Cases;
        $input = $request->all();

        $case->created_by_id = Auth::user()->id;
        $case->server = Auth::user()->server;
        $case->status = $input['status'];
        $case->race = Auth::user()->race;
        $case->type = $input['type'];
        $case->status = $input['status'];

        if (isset($input['description']) and !empty($input['description'])) {

            $case->description = $input['description'];

        }

        $case->department_id = $input['department_id'];
        $case->owner_id = $input['owner_id'];
        $case->admin_attention = $input['admin_attention'];

        if (isset($input['perpetrator']) and !empty($input['perpetrator'])) {

            $case->perpetrator = $input['perpetrator'];

        }

        $case->save();
        $perpetrators = $input['perpetrators'];
        if (Auth::user()->admin == 2) {
            //dd($perpetrators);
        }

        foreach ($perpetrators as $key => $value) {
            //$i = 0;
            //dd($value);

            foreach ($value as $v) {
                if (isset($v) and !empty($v)) {
                    $try_trim = array_filter(array_map('trim', explode(",", $v)), 'strlen');
                    //dd($try_trim);
                    if (count($try_trim) > 1) {

                        foreach ($try_trim as $v) {
                            $perp = new Perpetrator;
                            $perp->case_id = $case->id;
                            $perp->name = $v;

                            if ($key == 1) {
                                $perp->type = 1;
                            } elseif ($key == 2) {
                                $perp->type = 2;
                            } elseif ($key == 3) {
                                $perp->type = 3;
                            } elseif ($key == 4) {
                                $perp->type = 4;
                            } elseif ($key == 5) {
                                $perp->type = 5;
                            } else {
                                $perp->type = 0;
                            }
                            $perp->server = Auth::user()->server;
                            $perp->race = Auth::user()->race;
                            $perp->save();
                        }

                    } else {

                        $perp = new Perpetrator;
                        $perp->case_id = $case->id;
                        $perp->name = $v;

                        if ($key == 1) {
                            $perp->type = 1;
                        } elseif ($key == 2) {
                            $perp->type = 2;
                        } elseif ($key == 3) {
                            $perp->type = 3;
                        } elseif ($key == 4) {
                            $perp->type = 4;
                        } elseif ($key == 5) {
                            $perp->type = 5;
                        } else {
                            $perp->type = 0;
                        }

                        $perp->server = Auth::user()->server;
                        $perp->race = Auth::user()->race;
                        $perp->save();
                    }
                }
            }
        }

        Log::info(Auth::user()->name . '(' . Auth::user()->server . ')' . ' created a new case.  Number ' . $case->id);

        return redirect('cases');

    }

    public function create()
    {

        $guards = UserController::loadUsersAsArray();

        return view('cases.create')->with(['guards' => $guards]);

    }

    public function showHelpDeskCases()
    {

        $cases = DB::table('cases')
            ->where('server', '=', Auth::user()->server)
            ->where('department_id', '=', 5)
            ->where('status', '<', 3)
            ->where('deleted_at', '=', '0000-00-00 00:00:00')
            ->orderBy('updated_at', 'DESC')
            ->paginate(20);

        return view('cases.all')->with(['cases' => $cases]);

    }

    public function showMyDepartmentCases()
    {

        if (Auth::user()->department_id == 5) {

            $cases = DB::table('cases')
                ->where('server', '=', Auth::user()->server)
                ->where('department_id', '=', Auth::user()->department_id)
                ->where('status', '<', 3)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);

        } else {

            $cases = DB::table('cases')
                ->where('race', '=', Auth::user()->race)
                ->where('server', '=', Auth::user()->server)
                ->where('department_id', '=', Auth::user()->department_id)
                ->where('status', '<', 3)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);

        }

        return view('cases.all')->with(['cases' => $cases]);

    }

    public function showMyCases()
    {

        $cases = DB::table('cases')
            ->where('owner_id', '=', Auth::user()->id)
            ->where('status', '<', 3)
            ->where('deleted_at', '=', '0000-00-00 00:00:00')
            ->orderBy('updated_at', 'DESC')
            ->paginate(20);

        return view('cases.all')->with(['cases' => $cases]);

    }

    public static function myCasesCount()
    {

        if (Auth::guest()) {

        } else {

            $cases = Cases::where('owner_id', '=', Auth::user()->id)
                ->where('status', '<=', 2)// Status = New, In progress
                ->get();

            $count = $cases->count();

            return $count;

        }

    }

    public static function myDepartmentCasesCount()
    {

        if (Auth::guest()) {

        } else {

            if (Auth::user()->department_id == 5) {

                $cases = Cases::where('department_id', '=', Auth::user()->department_id)
                    ->where('server', '=', Auth::user()->server)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->where('status', '<=', 2)// Status = New, In progress
                    ->get();
            } else {

                $cases = Cases::where('department_id', '=', Auth::user()->department_id)
                    ->where('race', '=', Auth::user()->race)
                    ->where('server', '=', Auth::user()->server)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->where('status', '<=', 2)// Status = New, In progress
                    ->get();
            }

            $count = $cases->count();

            return $count;

        }

    }

    public function delete($id)
    {

        if ((Auth::user()->admin == 2) or (Auth::user()->admin == 1)) {
            $case = Cases::find($id);
            $case->deleted_at = date("Y-m-d H:i:s", time());
            $case->save();
            Log::info(Auth::user()->name . '(' . Auth::user()->server . ')' . 'deleted case number ' . $case->id);

            return redirect('cases');

        } else {

            return false;

        }

    }

    public function casesForAdmins()
    {

        $cases = DB::table('cases')
            ->where('admin_attention', '=', 1)
            ->where('server', '=', Auth::user()->server)
            ->where('deleted_at', '=', '0000-00-00 00:00:00')
            ->orderBy('updated_at', 'DESC')
            ->paginate(20);

        return view('cases.all')->with(['cases' => $cases]);

    }

    public static function adminCasesCount()
    {

        if (Auth::guest()) {

        } else {

            $cases = Cases::where('admin_attention', '=', 1)
                ->where('server', '=', Auth::user()->server)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

            $count = $cases->count();

            return $count;

        }

    }

    public static function helpdeskCasesCount()
    {

        if (Auth::guest()) {

        } elseif (!Auth::user()->helpdesk) {

        } else {

            $cases = Cases::where('department_id', '=', 5)
                ->where('status', '<', 3)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->where('server', '=', Auth::user()->server)
                ->get();

            $count = $cases->count();

            return $count;

        }

    }

    public function update(Request $request)
    {

        $this->validate($request, ['description' => 'max:40000']);
        $input = $request->all();
        $case = Cases::find($input['id']);
        $case->type = $input['type'];
        $case->status = $input['status'];

        if (isset($input['description']) and !empty($input['description'])) {
            $case->description = $input['description'];
        }

        $case->department_id = $input['department_id'];
        $case->owner_id = $input['owner_id'];
        $case->admin_attention = $input['admin_attention'];

        if (isset($input['perpetrator']) and !empty($input['perpetrator'])) {
            $case->perpetrator = $input['perpetrator'];
        }

        if (isset($input['currency']) and !empty($input['currency'])) {

            $case->currency = $input['currency'];

        }

        if (isset($input['fine']) and !empty($input['fine'])) {

            $case->fine = $input['fine'];

        }

        $case->save();

        $perpetrators = $input['perpetrators'];

        foreach ($perpetrators as $key => $value) {

            foreach ($value as $v) {
                if (isset($v) and !empty($v)) {
                    $try_trim = array_filter(array_map('trim', explode(",", $v)), 'strlen');

                    if (count($try_trim) > 1) {

                        foreach ($try_trim as $v) {
                            $perp = new Perpetrator;
                            $perp->case_id = $case->id;
                            $perp->name = $v;

                            if ($key == 1) {
                                $perp->type = 1;
                            } elseif ($key == 2) {
                                $perp->type = 2;
                            } elseif ($key == 3) {
                                $perp->type = 3;
                            } elseif ($key == 4) {
                                $perp->type = 4;
                            } elseif ($key == 5) {
                                $perp->type = 5;
                            } else {
                                $perp->type = 0;
                            }
                            $perp->server = Auth::user()->server;
                            $perp->race = Auth::user()->race;
                            $perp->save();
                        }

                    } else {

                        $perp = new Perpetrator;
                        $perp->case_id = $case->id;
                        $perp->name = $v;

                        if ($key == 1) {
                            $perp->type = 1;
                        } elseif ($key == 2) {
                            $perp->type = 2;
                        } elseif ($key == 3) {
                            $perp->type = 3;
                        } elseif ($key == 4) {
                            $perp->type = 4;
                        } elseif ($key == 5) {
                            $perp->type = 5;
                        } else {
                            $perp->type = 0;
                        }

                        $perp->server = Auth::user()->server;
                        $perp->race = Auth::user()->race;
                        $perp->save();
                    }
                }
            }
        }

        return redirect()->back();

    }


    public static function countCases($user_id, $status)
    {

        if (Auth::user()->rank == 3) {

            if ($status == 1) { // New cases

                $cases = Cases::where('status', '=', 1)
                    ->where('owner_id', '=', $user_id)
                    ->where('department_id', '=', Auth::user()->department_id)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 2) { // In progress

                $cases = Cases::where('status', '=', 2)
                    ->where('owner_id', '=', $user_id)
                    ->where('department_id', '=', Auth::user()->department_id)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 3) { // Closed

                $cases = Cases::where('status', '=', 3)
                    ->where('owner_id', '=', $user_id)
                    ->where('department_id', '=', Auth::user()->department_id)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            }

        } else {

            if ($status == 1) { // New cases

                $cases = Cases::where('status', '=', 1)
                    ->where('owner_id', '=', $user_id)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 2) { // In progress

                $cases = Cases::where('status', '=', 2)
                    ->where('owner_id', '=', $user_id)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 3) { // Closed

                $cases = Cases::where('status', '=', 3)
                    ->where('owner_id', '=', $user_id)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            }

        }

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->updated_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        return $cases->count();

    }

    public static function countTotalCases($status)
    {

        if (Auth::user()->admin == 2) {

            if ($status == 1) { // New cases

                $cases = Cases::where('status', '=', 1)
                    ->where('server', '=', Auth::user()->server)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 2) { // In progress

                $cases = Cases::where('status', '=', 2)
                    ->where('server', '=', Auth::user()->server)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 3) { // Closed

                $cases = Cases::where('status', '=', 3)
                    ->where('server', '=', Auth::user()->server)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            }

        } elseif (Auth::user()->admin == 1) {

            if ($status == 1) { // New cases

                $cases = Cases::where('status', '=', 1)
                    ->where('server', '=', Auth::user()->server)
                    ->where('race', '=', Auth::user()->race)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 2) { // In progress

                $cases = Cases::where('status', '=', 2)
                    ->where('server', '=', Auth::user()->server)
                    ->where('race', '=', Auth::user()->race)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 3) { // Closed

                $cases = Cases::where('status', '=', 3)
                    ->where('server', '=', Auth::user()->server)
                    ->where('race', '=', Auth::user()->race)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            }

        } elseif (Auth::user()->rank == 3) {

            if ($status == 1) { // New cases

                $cases = Cases::where('status', '=', 1)
                    ->where('server', '=', Auth::user()->server)
                    ->where('race', '=', Auth::user()->race)
                    ->where('department_id', '=', Auth::user()->department_id)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 2) { // In progress

                $cases = Cases::where('status', '=', 2)
                    ->where('server', '=', Auth::user()->server)
                    ->where('race', '=', Auth::user()->race)
                    ->where('department_id', '=', Auth::user()->department_id)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            } elseif ($status == 3) { // Closed

                $cases = Cases::where('status', '=', 3)
                    ->where('server', '=', Auth::user()->server)
                    ->where('race', '=', Auth::user()->race)
                    ->where('department_id', '=', Auth::user()->department_id)
                    ->where('deleted_at', '=', '0000-00-00 00:00:00')
                    ->get();

            }

        } else {

            return;

        }

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->updated_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        return $cases->count();

    }

    public static function countCreatedCases($user_id)
    {

        if (Auth::user()->rank == 3) {

            $cases = Cases::where('created_by_id', '=', $user_id)
                ->where('department_id', '=', Auth::user()->department_id)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

        } else {

            $cases = Cases::where('created_by_id', '=', $user_id)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')->get();

        }

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->created_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        return $cases->count();

    }

    public static function countTotalCreatedCases()
    {

        if (Auth::user()->admin == 2) {

            $cases = Cases::where('server', '=', Auth::user()->server)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

        } elseif (Auth::user()->admin == 1) {

            $cases = Cases::where('server', '=', Auth::user()->server)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->where('race', '=', Auth::user()->race)
                ->get();

        } elseif (Auth::user()->rank == 3) {

            $cases = Cases::where('server', '=', Auth::user()->server)
                ->where('department_id', '=', Auth::user()->department_id)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->where('race', '=', Auth::user()->race)
                ->get();

        } else {

            return;

        }

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->created_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        return $cases->count();

    }

    public function showUserCasesNew($id)
    {

        if (Auth::user()->rank == 3) {

            $cases = Cases::where('owner_id', '=', $id)
                ->where('status', '=', 1)
                ->where('department_id', '=', Auth::user()->department_id)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

        } else {

            $cases = Cases::where('owner_id', '=', $id)
                ->where('status', '=', 1)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

        }

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->updated_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        return view('cases.all')
            ->with(['cases' => $cases])
            ->with(['no_pagination' => true]);
    }

    public function showUserCasesInProgress($id)
    {

        if (Auth::user()->rank == 3) {

            $cases = Cases::where('owner_id', '=', $id)
                ->where('department_id', '=', Auth::user()->department_id)
                ->where('status', '=', 2)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

        } else {

            $cases = Cases::where('owner_id', '=', $id)
                ->where('status', '=', 2)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

        }

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->updated_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        return view('cases.all')
            ->with(['cases' => $cases])
            ->with(['no_pagination' => true]);
    }

    public function showUserCasesClosed($id)
    {

        if (Auth::user()->rank == 3) {

            $cases = Cases::where('owner_id', '=', $id)
                ->where('status', '=', 3)
                ->where('department_id', '=', Auth::user()->department_id)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

        } else {

            $cases = Cases::where('owner_id', '=', $id)
                ->where('status', '=', 3)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

        }

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->updated_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        return view('cases.all')
            ->with(['cases' => $cases])
            ->with(['no_pagination' => true]);
    }

    public function showUserCasesCreated($id)
    {

        $cases = Cases::where('created_by_id', '=', $id)
            ->get();

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->created_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        return view('cases.all')
            ->with(['cases' => $cases])
            ->with(['no_pagination' => true]);
    }

    public function search(Request $request)
    {

        $query = $request->get('q');
        if ($query) {

            Log::info(Auth::user()->name . '(' . Auth::user()->server . ')' . ' is making a search request for ' . $query);

            $cases = new \Illuminate\Support\Collection;
            $fetch = Perpetrator::where('name', 'LIKE', "%$query%")
                ->where('server', '=', Auth::user()->server)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

            foreach ($fetch as $p) {
                $case = Cases::find($p->case_id);
                $cases->push($case);
            }

            $old = Cases::where('perpetrator', 'LIKE', "%$query%")
                ->where('server', '=', Auth::user()->server)
                ->where('deleted_at', '=', '0000-00-00 00:00:00')
                ->get();

            foreach ($old as $o) {
                $cases->push($o);
            }


        } else {

            return 'no results';

        }
        $no_pagination = true;
        return view('cases.all')->with(['cases' => $cases])->with(['no_pagination' => $no_pagination]);

    }

    public static function calculateGivenFines()
    {


        $cases = Penalty::where('server', '=', Auth::user()->server)
            ->get();

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->updated_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        $fine_amount = array(0 => 0, 1 => 0);

        foreach ($cases as $case) {

            if (($case->currency == 1) and ($case->fine)) {

                $fine_amount[0] += $case->fine;

            } elseif (($case->currency == 2) and ($case->fine)) {

                $fine_amount[1] += $case->fine;
            } else {
            }

        }


        return $fine_amount;
    }

    public static function fineAmountDistributionCases($user_id)
    {
        $cases = Penalty::where('server', '=', Auth::user()->server)
            ->where('issued_by_id', '=', $user_id)
            ->get();

        $cases = $cases->filter(function ($case) {
            if ((time() - strtotime($case->updated_at)) <= 60 * 60 * 24 * 7) {
                return true;
            }
        });

        $fine_amount = array(0 => 0, 1 => 0);

        foreach ($cases as $case) {

            if (($case->currency == 1) and ($case->fine)) {

                $fine_amount[0] += $case->fine;

            } elseif (($case->currency == 2) and ($case->fine)) {

                $fine_amount[1] += $case->fine;
            } else {
            }

        }

        return $fine_amount;

    }

    public function updateDescription(Request $request) {

        $this->validate($request, ['description' => 'max:40000']);
        $input = $request->all();
        $case = Cases::find($input['id']);
        $case->description = $input['description'];
        $case->save();
        Log::info(Auth::user()->name . '(' . Auth::user()->server . ') updated description at case #' . $case->id);

        return '<script>window.opener.location.reload(false); this.close();</script>';

    }

    public function editDescription($id) {

        $case = Cases::find($id);

        return view('cases.edit_description')->with(['case' => $case]);
    }

}