<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Auth;
use Log;
use Request;

class UserController extends Controller
{


    public static function loadUsersAsArray()
    {
        if (Auth::user()->admin == 2) { // Load everybody for super admin

            $all = User::where('server', '=', Auth::user()->server)
                ->get();

        } elseif (Auth::user()->department_id == 5) { // Load only help desk staff

            $all = User::where('server', '=', Auth::user()->server)
                ->where('department_id', '=', 5)
                ->where('department_id', '=', Auth::user()->department_id)
                ->get();

        } elseif (Auth::user()->helpdesk) {

            $all = User::where('server', '=', Auth::user()->server)
                ->get();

        } else {

            $all = User::where('race', '=', Auth::user()->race)
                ->where('server', '=', Auth::user()->server)
                ->get();

        }

        $all_users = [];

        foreach ($all as $one) {
            $all_users = array_add($all_users, $one->id, $one->name);
        }

        return $all_users;
    }


    public function index()
    {
        $users = User::all();

        return view('users.all')->with(['users' => $users]);
    }

    public function stats()
    {
        if (Auth::guest()) {
            return redirect('auth/login');
        } elseif (Auth::user()->admin === 1) {
            $users = User::where('server', '=', Auth::user()->server)
                ->where('race', '=', Auth::user()->race)
                ->where('department_id', '<', 5)
                ->where('admin', '<', 2)
                ->get();
        } elseif (Auth::user()->admin === 2) {
            $users = User::where('server', '=', Auth::user()->server)
                ->where('department_id', '<', 5)
                ->where('admin', '<', 2)
                ->get();
        } elseif (Auth::user()->rank === 3) {
            $users = User::where('server', '=', Auth::user()->server)
                ->where('race', '=', Auth::user()->race)
                ->where('department_id', '=', Auth::user()->department_id)
                ->where('admin', '<', 2)
                ->get();
        } else {
            return redirect('home');
        }

        return view('users.stats')->with(['users' => $users]);

    }

    public function changeLanguage()
    {
        $input = $input = Request::all();
        if ($input['id'] == Auth::user()->id) {
            $user = User::find($input['id']);
            // Kostyl for 3k
            if ((Auth::user()->server == '3k') and ($input['language'] == 'ru')) {
                $user->language = '3k';
            } else {
                $user->language = $input['language'];
            }
            $user->save();

            return redirect()->back();
        } else {
            return redirect('home');
        }
    }

    public function show($id, $edit = false)
    {
        $user = User::find($id);
        if ($edit) {
            return view('users.edit.one')->with(['user' => $user]);
        } else {
            return view('users.one')->with(['user' => $user]);
        }
    }

    public function showToEdit($id)
    {
        $user = User::find($id);
        return view('users.edit.one')->with(['user' => $user]);
    }


    public function edit($id)
    {
        if (Auth::user()->admin) {
            $user = User::find($id);
            return view('users.edit')->with(['user' => $user]);
        } else {
            return false;
        }
    }


    public function upgrate($id)
    {
        $user = User::find($id);
        $input = Request::all();
        $user->name = $input['name'];
        $user->department_id = $input['department_id'];
        $user->rank = $input['rank'];
        $user->telegram = $input['telegram'];
        $user->race = $input['race'];
        $user->access = $input['access'];
        $user->server = $input['server'];
        // Kostyl for 3k
        if ($input['server'] == '3k') {
            $user->language = '3k';
        }
        $user->helpdesk = $input['helpdesk'];
        $user->save();

        Log::info(Auth::user()->name . '(' . Auth::user()->server . ') edited user ' . $user->name . '(ID=' . $user->id . '). New parameters: Dept: ' . $user->department_id . ' Rank:' . $user->rank . ' Race: ' . $user->race . ' Server: ' . $user->server . ' Helpdesk: ' . $user->helpdesk . ' Access: ' . $user->access);

        return redirect('/users');
    }

    public function loadGuardsStructure($server, $race)
    {
        if ($server !== Auth::user()->server) {
            return redirect('home');
        }

        $users = User::where('server', '=', $server)
            ->where('race', '=', $race)
            ->where('access', '=', 1)
            ->where('admin', '<', '2')
            ->get();

        $users = $users->sortByDesc('rank');

        $count = $users->count();

        $new_users = User::where('access', '=', 0)->where('department_id', '=', 0)->get();
        $count_new = $new_users->count();

        return view('users.structure')
            ->with(['users' => $users])
            ->with(['count' => $count])
            ->with(['count_new' => $count_new]);
    }

}
