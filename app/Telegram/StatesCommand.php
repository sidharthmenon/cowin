<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Ixudra\Curl\Facades\Curl;

class StatesCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "states";

    /**
     * @var string Command Description
     */
    protected $description = "Get states and their code";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {

      $this->replyWithChatAction(['action' => Actions::TYPING]);

      $response = Curl::to('https://cdn-api.co-vin.in/api/v2/admin/location/states')
                    ->withHeader('User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:88.0) Gecko/20100101 Firefox/88.0')
                    ->asJson()
                    ->get();

      $states = $response->states;

      if(count($states)){
        $text = '';
        foreach ($states as $state) {
            $text .= sprintf('`/district %s` - %s'.PHP_EOL, $state->state_id, $state->state_name);
        }

        $this->replyWithMessage(['text' => $text, 'parse_mode' => 'Markdown']);
      }
      else{
        $this->replyWithMessage(['text' => 'Invalid']);
        $this->triggerCommand('help');
      }
      
    }
}