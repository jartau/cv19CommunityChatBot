<?php


namespace App\BotService;


use App\Conversations\RequestMaterialConversation;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;

class Bot implements BotInterface
{
    /**
     * @var \BotMan\BotMan\BotMan
     */
    protected $botman;

    public function __construct()
    {
        // Load the driver(s) you want to use
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);

        // Create an instance
        $this->botman = BotManFactory::create([
            'telegram' => [
                'token' => env('TELEGRAM_TOKEN')
            ]
        ], new LaravelCache());
    }

    private function showHelp(): void
    {
        $this->botman->reply(__('chatbot.help_intro'));
        $this->botman->reply(__('chatbot.help_request', [
            'cmd_request' => __('chatbot.cmd_request')
        ]));
        $this->botman->reply(__('chatbot.help_help', [
            'cmd_help' => __('chatbot.cmd_help')
        ]));
    }


    public function hear(): void
    {

        $this->botman->hears('/start', function () {
            $this->showHelp();
        });

        $this->botman->hears(__('chatbot.cmd_help'), function () {
            $this->showHelp();
        });

        $this->botman->hears(__('chatbot.cmd_request'), function () {
            $this->botman->startConversation(new RequestMaterialConversation());
        });

        // Start listening
        $this->botman->listen();
    }

}