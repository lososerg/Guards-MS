<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Irazasyed\Telegram\Telegram;
use Log;
use DB;

class SendAnekdotesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'anekdot:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sends anekdots to subscribers.';

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
        static $subscription_jokes = ['Анекдоты на сегодня',];
        $t = new Telegram('***');
        $html = file_get_contents('http://www.anekdot.ru/last/anekdot/');
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $finder = new \DomXPath($dom);
        $classname = "topicbox";
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        foreach ($nodes as $node) {
            $anekdot = $finder->query("./div[@class='text']", $node);

            if ($anekdot->length > 0) {
                $subscription_jokes[] = $anekdot->item(0)->nodeValue;
            }
        }

        $subscribers = DB::table('anekdot_subscribtions')->where('enabled', 1)->get();
        foreach ($subscribers as $sub) {
            foreach($subscription_jokes as $joke) {
                $t->sendMessage($sub->chat_id, $joke);
            }
            Log::info('Jokes were sent to user' . $sub->id);
        }

        /*
         * DB::table('anekdot_subscribtions')->chunk(100, function($users)
        {
            foreach ($users as $user)
            {
                foreach($subscription_jokes as $joke) {
                    $t->sendMessage($user->chat_id, $joke);
                }
                Log::info('Jokes were sent to user' . $user->id);
            }
        });
        */

        $this->info('Jokes were sent!');
	}


}
