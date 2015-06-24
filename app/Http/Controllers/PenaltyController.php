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

        if (2 !== Auth::user()->admin) {
            return 'Access denied';
        }

        $servers = [
            'com',
            'de',
            'pl',
            'w1',
            'w2',
        ];

        $handled_perpetrators_count = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
        ];
        $have_penalty = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
        ];
        $free = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
        ];
        $had_penalty = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
        ];
        $gold_paid = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
        ];
        $failed_lookup = [];
        $users_dont_exist = [];
        $failed_users_count = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
        ];
        $free_people = [];
        foreach ($servers as $server) {
            $perpetrators = Perpetrator::where('server', '=', $server)->where('deleted_at', '=', '0000-00-00 00:00:00')->get();
            foreach ($perpetrators as $p) {
                //Check if username is valid
                if ('com' == $server) {
                    $check = file_get_contents('http://warofdragons.com/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'User not found!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        $users_dont_exist[$server][] = $p->name;
                        continue;
                    }
                } elseif ('de' == $server) {
                    $check = file_get_contents('http://warofdragons.de/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'User nicht gefunden!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        $users_dont_exist[$server][] = $p->name;
                        continue;
                    }
                } elseif ('pl' == $server) {
                    $check = file_get_contents('http://warofdragons.pl/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'Użytkownik nie został znaleziony!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        $users_dont_exist[$server][] = $p->name;
                        continue;
                    }
                } elseif ('w1' == $server) {
                    $check = file_get_contents('http://w1.dwar.ru/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'Пользователь не найден!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        $users_dont_exist[$server][] = $p->name;
                        continue;
                    }
                } elseif ('w2' == $server) {
                    $check = file_get_contents('http://w2.dwar.ru/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'Пользователь не найден!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        $users_dont_exist[$server][] = $p->name;
                        continue;
                    }
                } else {
                    // Do nothing
                }
                // User exists, checking penalty
                if ($p->penalty) {
                    if ((1 === $p->penalty->currency) && ($p->penalty->fine > 0)) {
                        if ('com' == $server) {
                            $s = file_get_contents('http://www.warofdragons.com/punishment_info.php?nick=' . urlencode($p->name));
                            if ($s) {
                                $try = strpos($s, 'This user is not under any curse!');
                                if ($try) {
                                    // User has no Curses
                                    ++$free[$server];
                                    $free_people[$server][$p->name] = round(($p->penalty->fine/100), 0);
                                    $gold_paid[$server] += $p->penalty->fine;
                                } else {
                                    // User in in prison
                                    ++$have_penalty[$server];
                                }
                                ++$had_penalty[$server];
                            } else {
                                ++$failed_lookup[$server];
                            }
                        } elseif ('de' == $server) {
                            $s = file_get_contents('http://www.warofdragons.de/punishment_info.php?nick=' . urlencode($p->name));
                            if ($s) {
                                $try = strpos($s, 'Dieser Spieler ist frei von Flüchen!');
                                if ($try) {
                                    // User has no Curses
                                    ++$free[$server];
                                    $free_people[$server][$p->name] = round(($p->penalty->fine/100), 0);
                                    $gold_paid[$server] += $p->penalty->fine;
                                } else {
                                    // User in in prison
                                    ++$have_penalty[$server];
                                }
                                ++$had_penalty[$server];
                            } else {
                                ++$failed_lookup[$server];
                            }
                        } elseif ('pl' == $server) {
                            $s = file_get_contents('http://www.warofdragons.pl/punishment_info.php?nick=' . urlencode($p->name));
                            if ($s) {
                                $try = strpos($s, 'Na tego użytkownika nie zostały rzucone zaklęcia!');
                                if ($try) {
                                    // User has no Curses
                                    ++$free[$server];
                                    $free_people[$server][$p->name] = round(($p->penalty->fine/100), 0);
                                    $gold_paid[$server] += $p->penalty->fine;
                                } else {
                                    // User in in prison
                                    ++$have_penalty[$server];
                                }
                                ++$had_penalty[$server];
                            } else {
                                ++$failed_lookup[$server];
                            }
                        } elseif ('w1' == $server) {
                            $s = file_get_contents('http://w1.dwar.ru/punishment_info.php?nick=' . urlencode($p->name));
                            if ($s) {
                                $try = strpos($s, 'На этого пользователя не наложены проклятья!');
                                if ($try) {
                                    // User has no Curses
                                    ++$free[$server];
                                    $free_people[$server][$p->name] = round(($p->penalty->fine/100), 0);
                                    $gold_paid[$server] += $p->penalty->fine;
                                } else {
                                    // User in in prison
                                    ++$have_penalty[$server];
                                }
                                ++$had_penalty[$server];
                            } else {
                                ++$failed_lookup[$server];
                            }
                        } elseif ('w2' == $server) {
                            $s = file_get_contents('http://w2.dwar.ru/punishment_info.php?nick=' . urlencode($p->name));
                            if ($s) {
                                $try = strpos($s, 'На этого пользователя не наложены проклятья!');
                                if ($try) {
                                    // User has no Curses
                                    ++$free[$server];
                                    $free_people[$server][$p->name] = round(($p->penalty->fine/100), 0);
                                    $gold_paid[$server] += $p->penalty->fine;
                                } else {
                                    // User in in prison
                                    ++$have_penalty[$server];
                                }
                                ++$had_penalty[$server];
                            } else {
                                ++$failed_lookup[$server];
                            }
                        } else {
                            // Do nothing
                        }



                    } else {

                    }

                } else {

                }
                ++$handled_perpetrators_count[$server];
                Log::info('Handled server ' . $server . ', perpetrator ' . $handled_perpetrators_count[$server]);
            }
        }

        //$people = implode($free_people);
        return view('fine_payments')
            ->with(['handled_perpetrators_count' => $handled_perpetrators_count])
            ->with(['failed_users_count' => $failed_users_count])
            ->with(['had_penalty' => $had_penalty])
            ->with(['have_penalty' => $have_penalty])
            ->with(['free' => $free])
            ->with(['gold_paid' => $gold_paid]);
    }

}
