<?php

namespace App\Http\Controllers;

use App\Conversations\RequestMaterialConversation;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{

    protected $bot;

    public function __construct()
    {
        // Load the driver(s) you want to use
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);

        // Create an instance
        $this->bot = BotManFactory::create([
            'telegram' => [
                'token' => env('TELEGRAM_TOKEN')
            ]
        ], new LaravelCache());
    }

    private function showHelp(): void
    {
        $this->bot->reply(__('chatbot.help_intro'));
        $this->bot->reply(__('chatbot.help_help', [
            'cmd_help' => __('chatbot.cmd_help')
        ]));
        $this->bot->reply(__('chatbot.help_request', [
            'cmd_request' => __('chatbot.cmd_request')
        ]));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handle()
    {
        $this->bot->hears('/start', function () {
            $this->showHelp();
        });

        $this->bot->hears(__('chatbot.cmd_help'), function () {
            $this->showHelp();
        });

        $this->bot->hears(__('chatbot.cmd_request'), function () {
            $this->bot->startConversation(new RequestMaterialConversation());
        });

        // Start listening
        $this->bot->listen();
    }

}
