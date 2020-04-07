<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;

class BotController extends Controller
{

    protected $bot;

    /*public function __construct()
    {
        $config = [
            'telegram' => [
                'token' => env('TELEGRAM_TOKEN')
            ]
        ];
        // Load the driver(s) you want to use
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
        // Create an instance
        $this->bot = BotManFactory::create($config, new LaravelCache());
    }*/

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handle()
    {
        return 'hello';
        // Give the bot something to listen for.
        $this->bot->hears('/ajuda', function () {
            $this->showHelp();
        });

        /*$this->bot->hears('/demanar', function () {
            $this->bot->startConversation();
        });*/

        // Start listening
        $this->bot->listen();
    }

}
