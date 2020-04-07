<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;

class TelegramRegisterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:telegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register Telegram web hook url';

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
    public function handle()
    {
        try {
            $url = 'https://api.telegram.org/bot' . env('TELEGRAM_TOKEN')
                . '/setWebhook?url=' . route('bot');
            $this->info('Calling "' . $url . '"...');
            $output = json_decode(file_get_contents($url));

            if ($output->ok == true && $output->result == true) {
                $this->info('Done!');
            } else {
                $this->error('Error at calling telegram API');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}