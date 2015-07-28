<?php namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Irazasyed\Telegram\Telegram;
use Log;

class AnekdotCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'anekdot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $t = new Telegram('***');
        $updates = $t->getUpdates();
        $decode = json_decode($updates, true);
        foreach ($decode as $d) {
            $confirmed_offset = $d["update_id"] + 1;
            $t->getUpdates($confirmed_offset); // Подтверждаем апдейд
            $chat_id = $d["message"]["chat"]["id"];
            $text = $d["message"]["text"];

            //Список поддерживаемых комманд

            if ($text == '/start') {
                $t->sendMessage($chat_id, "Привет!\nОтправьте команду /subscribe, чтобы подписаться на ежедневную рассылку анекдотов.\nЕсли надоест, вы всегда сможете отписаться - просто отправьте /unsubscribe.\nЕсли хотите получить 20 случайных анекдотов прямо сейчас, отправьте /anekdot.\n\nЕсли вам понравился бот, поставьте ему 5 звезд и оставьте отзыв по этой ссылке https://telegram.me/storebot?start=anekdotrubot");
                $is_in_db = DB::table('anekdot_subscribtions')->where('chat_id', $chat_id)->get();
                if (!$is_in_db) {
                    DB::table('anekdot_subscribtions')->insert(
                        ['chat_id' => $chat_id, 'first_name' => $d["message"]["chat"]["first_name"], 'enabled' => 0,]
                    );
                }

            } elseif ($text == '/anekdot') {

                $html = file_get_contents('http://www.anekdot.ru/random/anekdot/');
                $dom = new \DOMDocument();
                @$dom->loadHTML($html);
                $finder = new \DomXPath($dom);
                $classname = "topicbox";
                $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

                foreach ($nodes as $node) {
                    $anekdot = $finder->query("./div[@class='text']", $node);
                    if ($anekdot->length > 0) {
                        $t->sendMessage($chat_id, str_replace("<br>","\n", $anekdot->item(0)->nodeValue));
                    }
                }
            } elseif ($text == '/help') {
                $t->sendMessage($chat_id, "Доступные команды:\n\n/subscribe - подписаться на рассылку анекдотов раз в день;\n/ubsubscribe - отписаться от рассылки;\n/anekdot - получить 20 случайных анекдотов;\n\nАвтор бота: @krypto\n\nЕсли вам понравился бот, поставьте ему 5 звезд и оставьте отзыв по этой ссылке https://telegram.me/storebot?start=anekdotrubot");
            } elseif ($text == '/subscribe') {

                //Проверяем есть ли такой пользователь в базе
                $is_in_db = DB::table('anekdot_subscribtions')->where('chat_id', $chat_id)->get();

                if ($is_in_db) {
                    $subscription_is_enabled = DB::table('anekdot_subscribtions')->where('chat_id', $chat_id)->where('enabled', 1)->get();
                    if ($subscription_is_enabled) {
                        $t->sendMessage($chat_id, "Вы уже подписаны на рассылку анекдотов.\n\nЧтобы отписаться отправьте команду /unsubscribe\nЧтобы вызвать меню помощи - /help");
                    } else {
                        DB::table('anekdot_subscribtions')
                            ->where('chat_id', $chat_id)
                            ->update(['enabled' => 1]);
                        $t->sendMessage($chat_id, "Вы вновь подписались на рассылку анекдотов.\n\nЧтобы отписаться отправьте команду /unsubscribe\n\nЧтобы вызвать меню помощи - /help ");
                    }
                } else {
                    DB::table('anekdot_subscribtions')->insert(
                        ['chat_id' => $chat_id, 'first_name' => $d["message"]["chat"]["first_name"], 'enabled' => 0,]
                    );
                    $t->sendMessage($chat_id, "Вы подписались на рассылку анекдотов.\n\nЧтобы отписаться отправьте команду /unsubscribe\nЧтобы вызвать меню помощи - /help");
                }

            } elseif ($text == "/unsubscribe") {

                $is_in_db = DB::table('anekdot_subscribtions')->where('chat_id', $chat_id)->get();

                if ($is_in_db) {
                    $subscription_is_enabled = DB::table('anekdot_subscribtions')->where('chat_id', $chat_id)->where('enabled', 1)->get();
                    if ($subscription_is_enabled) {
                        DB::table('anekdot_subscribtions')
                            ->where('chat_id', $chat_id)
                            ->update(['enabled' => 0]);
                        $t->sendMessage($chat_id, "Вы отписались от рассылки анекдотов.\n\nЧтобы подписаться отправьте команду /subscribe\nЧтобы вызвать меню помощи - /help");
                    } else {
                        $t->sendMessage($chat_id, "Вы не подписаны на рассылки анекдотов.\n\nЧтобы подписаться отправьте команду /subscribe\nЧтобы вызвать меню помощи - /help");
                    }
                } else {
                    $t->sendMessage($chat_id, "Вы не подписаны на рассылки анекдотов.\n\nЧтобы подписаться отправьте команду /subscribe\nЧтобы вызвать меню помощи - /help");
                }

            } else {
                $t->sendMessage($chat_id, "Я не знаю команду " . $text . ".\n\nВызовите меню помощи командой /help");
            }
        }
    }
}
