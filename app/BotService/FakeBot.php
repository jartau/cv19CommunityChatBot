<?php


namespace App\BotService;


use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\Tests\FakeDriver;
use BotMan\Studio\Testing\BotManTester;

class FakeBot extends Bot
{
    protected $botman;
    protected $tester;

    public function __construct()
    {
        $driver = new FakeDriver();
        $this->botman = BotManFactory::create([]);
        $this->botman->setDriver($driver);
        $this->tester = new BotManTester($this->botman, $driver);
    }

    public function getTester(): BotManTester
    {
        return $this->tester;
    }
}