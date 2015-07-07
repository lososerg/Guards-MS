<?php namespace App\Console\Commands;

use App\Perpetrator;
use DB;
use Illuminate\Console\Command;

class StatsCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'stats:collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launches stats collection script.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        $servers = [
            'com',
            'de',
            'pl',
            'w1',
            'w2',
            '3k',
        ];

        $handled_perpetrators_count = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
            '3k' => 0,
        ];
        $have_penalty = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
            '3k' => 0,
        ];
        $free = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
            '3k' => 0,
        ];
        $had_penalty = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
            '3k' => 0,
        ];
        $gold_paid = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
            '3k' => 0,
        ];
        $failed_lookup = [];
        $users_dont_exist = [];
        $failed_users_count = [
            'com' => 0,
            'de' => 0,
            'pl' => 0,
            'w1' => 0,
            'w2' => 0,
            '3k' => 0,
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
                        DB::table('stats_errors')->insert(
                            ['server' => $p->server, 'perp_id' => $p->id, 'perp_name' => $p->name, 'case_id' => $p->case_id, 'race' => $p->race, 'date' => date("Y-m-d H:i:s", time())]
                        );

                        continue;
                    }
                } elseif ('de' == $server) {
                    $check = file_get_contents('http://warofdragons.de/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'User nicht gefunden!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        DB::table('stats_errors')->insert(
                            ['server' => $p->server, 'perp_id' => $p->id, 'perp_name' => $p->name, 'case_id' => $p->case_id, 'race' => $p->race, 'date' => date("Y-m-d H:i:s", time())]
                        );
                        continue;
                    }
                } elseif ('pl' == $server) {
                    $check = file_get_contents('http://warofdragons.pl/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'Użytkownik nie został znaleziony!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        DB::table('stats_errors')->insert(
                            ['server' => $p->server, 'perp_id' => $p->id, 'perp_name' => $p->name, 'case_id' => $p->case_id, 'race' => $p->race, 'date' => date("Y-m-d H:i:s", time())]
                        );
                        continue;
                    }
                } elseif ('w1' == $server) {
                    $check = file_get_contents('http://w1.dwar.ru/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'Пользователь не найден!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        DB::table('stats_errors')->insert(
                            ['server' => $p->server, 'perp_id' => $p->id, 'perp_name' => $p->name, 'case_id' => $p->case_id, 'race' => $p->race, 'date' => date("Y-m-d H:i:s", time())]
                        );
                        continue;
                    }
                } elseif ('w2' == $server) {
                    $check = file_get_contents('http://w2.dwar.ru/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'Пользователь не найден!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        DB::table('stats_errors')->insert(
                            ['server' => $p->server, 'perp_id' => $p->id, 'perp_name' => $p->name, 'case_id' => $p->case_id, 'race' => $p->race, 'date' => date("Y-m-d H:i:s", time())]
                        );
                        continue;
                    }
                } elseif ('3k' == $server) {
                    $check = file_get_contents('http://3k.mail.ru/user_info.php?nick=' . urlencode($p->name));
                    $not_exist = strpos($check, 'Пользователь не найден!');
                    if ($not_exist) {
                        ++$failed_users_count[$server];
                        DB::table('stats_errors')->insert(
                            ['server' => $p->server, 'perp_id' => $p->id, 'perp_name' => $p->name, 'case_id' => $p->case_id, 'race' => $p->race, 'date' => date("Y-m-d H:i:s", time())]
                        );
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
                                    $free_people[$server][$p->name] = round(($p->penalty->fine / 100), 0);
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
                                    $free_people[$server][$p->name] = round(($p->penalty->fine / 100), 0);
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
                                    $free_people[$server][$p->name] = round(($p->penalty->fine / 100), 0);
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
                                    $free_people[$server][$p->name] = round(($p->penalty->fine / 100), 0);
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
                                    $free_people[$server][$p->name] = round(($p->penalty->fine / 100), 0);
                                    $gold_paid[$server] += $p->penalty->fine;
                                } else {
                                    // User in in prison
                                    ++$have_penalty[$server];
                                }
                                ++$had_penalty[$server];
                            } else {
                                ++$failed_lookup[$server];
                            }
                        } elseif ('3k' == $server) {
                            $s = file_get_contents('http://3k.mail.ru/punishment_info.php?nick=' . urlencode($p->name));
                            if ($s) {
                                $try = strpos($s, 'На этого персонажа не наложены наказания!');
                                if ($try) {
                                    // User has no Curses
                                    ++$free[$server];
                                    $free_people[$server][$p->name] = round(($p->penalty->fine / 100), 0);
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
            }
        }
        //$people = implode($free_people);
        foreach ($servers as $s) {
            $total_cases[$s] =  DB::table('cases')->where('server', '=', $s)->count();
            DB::table('stats_log')->insert(
                ['server' => $s,
                    'date' => date("Y-m-d H:i:s", time()),
                    'total_checked' => $handled_perpetrators_count[$s],
                    'total_failed' => $failed_users_count[$s],
                    'total_with_penalty' => $had_penalty[$s],
                    'with_penalty_now' => $have_penalty[$s],
                    'free' => $free[$s],
                    'paid_gold' => $gold_paid[$s],
                    'total_cases' => $total_cases[$s],
                ]
            );
        }
        $this->info('Script successfully completed execution');
        return true;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    /*protected function getArguments()
    {

          return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];

    }
*/

    /**
     * Get the console command options.
     *
     * @return array
     */
    /*protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
*/

}
