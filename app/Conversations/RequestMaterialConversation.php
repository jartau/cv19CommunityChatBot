<?php


namespace App\Conversations;


use App\Mail\MaterialRequest;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Mail;

class RequestMaterialConversation extends Conversation
{

    protected $name;
    protected $location;
    protected $cp;
    protected $address;
    protected $mail;
    protected $phone;
    protected $entity;
    protected $description;

    public function __construct()
    {
        $this->name = '';
        $this->location = '';
        $this->cp = '';
        $this->address = '';
        $this->mail = '';
        $this->phone = '';
        $this->entity = '';
        $this->description = '';
    }

    public function sendConfirmation(): void
    {
        Mail::to(env('MAIL_TO'))->send(new MaterialRequest(
            [
                'name' => $this->name,
                'location' => $this->location,
                'cp' => $this->cp,
                'address' => $this->address,
                'mail' => $this->mail,
                'phone' => $this->phone,
                'entity' => $this->entity,
                'description' => $this->description,
            ]
        ));
    }

    public function confirm(): void
    {

        $this->say(__('chatbot.confirm_title'));

        $this->say(__('chatbot.name') . ': ' . $this->name);
        $this->say(__('chatbot.location') . ': ' . $this->location);
        $this->say(__('chatbot.cp') . ': ' . $this->cp);
        $this->say(__('chatbot.address') . ': ' . $this->address);
        $this->say(__('chatbot.mail') . ': ' . $this->mail);
        $this->say(__('chatbot.phone') . ': ' . $this->phone);
        $this->say(__('chatbot.entity') . ': ' . $this->entity);
        $this->say(__('chatbot.description') . ': ' . $this->description);

        $this->ask(__('chatbot.confirm_question', [
            'cmd_confirm_yes' => __('chatbot.cmd_confirm_yes'),
            'cmd_confirm_no' => __('chatbot.cmd_confirm_no')
        ]), function (Answer $answer) {
            if ($answer->getText() === __('chatbot.cmd_confirm_yes')) {
                $this->sendConfirmation();
                $this->say(__('chatbot.confirm_ok'));
            } else {
                $this->say(__('chatbot.confirm_ko'));
            }
        });
    }

    public function askName(): void
    {
        $this->ask(__('chatbot.ask_name'), function (Answer $answer) {
            $this->name = $answer->getText();
            $this->askLocation();
        });
    }

    public function askLocation(): void
    {
        $this->ask(__('chatbot.ask_location'), function (Answer $answer) {
            $this->location = $answer->getText();
            $this->askCp();
        });
    }

    public function askCp(): void
    {
        $this->ask(__('chatbot.ask_cp'), function (Answer $answer) {
            $this->cp = $answer->getText();
            $this->askAddress();
        });
    }

    public function askAddress(): void
    {
        $this->ask(__('chatbot.ask_address'), function (Answer $answer) {
            $this->address = $answer->getText();
            $this->askMail();
        });
    }

    public function askMail(): void
    {
        $this->ask(__('chatbot.ask_mail'), function (Answer $answer) {
            $this->mail = $answer->getText();
            $this->askPhone();
        });
    }

    public function askPhone(): void
    {
        $this->ask(__('chatbot.ask_phone'), function (Answer $answer) {
            $this->phone = $answer->getText();
            $this->askEntity();
        });
    }

    public function askEntity(): void
    {
        $this->ask(__('chatbot.ask_entity'), function (Answer $answer) {
            $this->entity = $answer->getText();
            $this->askDescription();
        });
    }

    public function askDescription(): void
    {
        $this->ask(__('chatbot.ask_description'), function (Answer $answer) {
            $this->description = $answer->getText();
            $this->confirm();
        });
    }

    public function run(): void
    {
        $this->say(__('chatbot.run_desc_1'));
        $this->say(__('chatbot.run_desc_2'));
        //$this->say('Pot cancel·lar el proces en qualsevol moment fent click o escribint /atura');
        $this->askName();
    }

    /*public function stopsConversation(IncomingMessage $message)
    {
        if ($message->getText() == 'atura') {
            $this->say('S\'ha cancelat el proces de solicitud de enviament');
            return true;
        }
        return false;
    }*/
}