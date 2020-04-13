<?php

namespace App\Http\Controllers;

use App\BotService\BotInterface;
use App\Conversations\RequestMaterialConversation;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{

    protected $bot;

    public function __construct(BotInterface $bot)
    {
        $this->bot = $bot;
    }

    /**
     * Bot hear action
     *
     * @return void
     */
    public function handle(): void
    {
        $this->bot->hear();
    }

}
