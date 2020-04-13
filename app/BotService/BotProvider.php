<?php


namespace App\BotService;

use Illuminate\Support\ServiceProvider;

class BotProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BotInterface::class, function () {
            return new Bot();
        });
    }
}