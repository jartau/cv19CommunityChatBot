<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\MaterialRequest;

class BotTest extends TestCase
{
    protected $tester;

    public function setUp()
    {
        parent::setUp();

        $bot = new \App\BotService\FakeBot();
        $this->tester = $bot->getTester();
        $bot->hear();

    }

    private function helpAssertions(): void
    {
        $this->tester->assertReplies([
            __('chatbot.help_intro'),
            __('chatbot.help_request', [
                'cmd_request' => __('chatbot.cmd_request')
            ]),
            __('chatbot.help_help', [
                'cmd_help' => __('chatbot.cmd_help')
            ])
        ]);
    }

    public function testStart(): void
    {
        $this->tester->receives('/start');
        $this->helpAssertions();;
    }

    public function testHelp(): void
    {
        $this->tester->receives(__('chatbot.cmd_help'));
        $this->helpAssertions();
    }

    public function testRequestMaterialConversationConfirmed(): void
    {
        \Illuminate\Support\Facades\Config::set('mail.to_address', 'fake@mail.com');
        Mail::fake();

        $this->tester
            ->receives(__('chatbot.cmd_request'))
            ->assertReplies([
                __('chatbot.run_desc_1'),
                __('chatbot.run_desc_2'),
                __('chatbot.ask_name')
            ])
            ->receives('My Name And Surname')
            ->assertReply(__('chatbot.ask_location'))
            ->receives('My Town Name')
            ->assertReply(__('chatbot.ask_cp'))
            ->receives('12345')
            ->assertReply(__('chatbot.ask_address'))
            ->receives('My personal address')
            ->assertReply(__('chatbot.ask_mail'))
            ->receives('my@mail.adress')
            ->assertReply(__('chatbot.ask_phone'))
            ->receives('123456789')
            ->assertReply(__('chatbot.ask_entity'))
            ->receives('Entity legal name')
            ->assertReply(__('chatbot.ask_description'))
            ->receives('Very long description')
            ->assertReplies([
                __('chatbot.confirm_title'),
                __('chatbot.name') . ': My Name And Surname',
                __('chatbot.location') . ': My Town Name',
                __('chatbot.cp') . ': 12345',
                __('chatbot.address') . ': My personal address',
                __('chatbot.mail') . ': my@mail.adress',
                __('chatbot.phone') . ': 123456789',
                __('chatbot.entity') . ': Entity legal name',
                __('chatbot.description') . ': Very long description',
                __('chatbot.confirm_question', [
                    'cmd_confirm_yes' => __('chatbot.cmd_confirm_yes'),
                    'cmd_confirm_no' => __('chatbot.cmd_confirm_no')
                ])
            ])
            ->receives(__('chatbot.cmd_confirm_yes'))
            ->assertReply(__('chatbot.confirm_ok'));

        Mail::assertSent(MaterialRequest::class, function ($mail) {
            return $mail->hasTo(config('mail.to_address'));
        });
    }

    public function testRequestMaterialConversationCancelled(): void
    {
        Mail::fake();

        $this->tester
            ->receives(__('chatbot.cmd_request'))
            ->assertReplies([
                __('chatbot.run_desc_1'),
                __('chatbot.run_desc_2'),
                __('chatbot.ask_name')
            ])
            ->receives('My Name And Surname')
            ->assertReply(__('chatbot.ask_location'))
            ->receives('My Town Name')
            ->assertReply(__('chatbot.ask_cp'))
            ->receives('12345')
            ->assertReply(__('chatbot.ask_address'))
            ->receives('My personal address')
            ->assertReply(__('chatbot.ask_mail'))
            ->receives('my@mail.adress')
            ->assertReply(__('chatbot.ask_phone'))
            ->receives('123456789')
            ->assertReply(__('chatbot.ask_entity'))
            ->receives('Entity legal name')
            ->assertReply(__('chatbot.ask_description'))
            ->receives('Very long description')
            ->assertReplies([
                __('chatbot.confirm_title'),
                __('chatbot.name') . ': My Name And Surname',
                __('chatbot.location') . ': My Town Name',
                __('chatbot.cp') . ': 12345',
                __('chatbot.address') . ': My personal address',
                __('chatbot.mail') . ': my@mail.adress',
                __('chatbot.phone') . ': 123456789',
                __('chatbot.entity') . ': Entity legal name',
                __('chatbot.description') . ': Very long description',
                __('chatbot.confirm_question', [
                    'cmd_confirm_yes' => __('chatbot.cmd_confirm_yes'),
                    'cmd_confirm_no' => __('chatbot.cmd_confirm_no')
                ])
            ])
            ->receives(__('chatbot.cmd_confirm_no'))
            ->assertReply(__('chatbot.confirm_ko'));

        Mail::assertNothingSent();
    }

}