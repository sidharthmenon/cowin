<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Ixudra\Curl\Facades\Curl;
use Telegram\Bot\Laravel\Facades\Telegram;

class DistrictCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "district";

    /**
     * @var string Command Description
     */
    protected $description = "Enter /district <state code> to get districts of state";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {

      if($arguments){
        $district = explode(" ", $arguments)[0];
      }
      else{
        $this->replyWithMessage(['text' => 'District code not found. Enter /district <state code>']);
        $this->triggerCommand('help');
        return;
      }
      
      $this->replyWithChatAction(['action' => Actions::TYPING]);

      $response = Curl::to('https://cdn-api.co-vin.in/api/v2/admin/location/districts/'.$district)
                    ->withHeader('User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:88.0) Gecko/20100101 Firefox/88.0')
                    ->asJson()
                    ->get();

      $districts = $response->districts;

      if(count($districts)){
        $text = '';
        foreach ($districts as $district) {
            $text .= sprintf('`/slot %s` - %s'.PHP_EOL, $district->district_id, $district->district_name);
        }

        $this->replyWithMessage(['text' => $text, 'parse_mode' => 'Markdown']);
      }
      else{
        $this->replyWithMessage(['text' => 'Invalid District']);
        $this->triggerCommand('help');
      }
      
    }
}