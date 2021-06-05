<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Ixudra\Curl\Facades\Curl;
use Telegram\Bot\Laravel\Facades\Telegram;

class SlotCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "slot";

    /**
     * @var string Command Description
     */
    protected $description = "Enter /slot <district code> to get slots in district";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {

      if($arguments){
        $district = explode(" ", $arguments)[0];
      }
      else{
        $this->replyWithMessage(['text' => 'District code not found. Enter /slot <district code>']);
        $this->triggerCommand('help');
        return;
      }
      
      $this->replyWithChatAction(['action' => Actions::TYPING]);

      $response = Curl::to('https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/findByDistrict')
                    ->withData( [ 'district_id' => $district, 'date' => date('d-m-Y') ] )
                    ->withHeader('User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:88.0) Gecko/20100101 Firefox/88.0')
                    ->asJson()
                    ->get();

      $sessions = $response->sessions;

      $sessions = array_filter($sessions, function($item) {
        return $item->available_capacity > 0;
      });

      if(count($sessions)==0){
        $this->replyWithMessage(['text' => 'No Slots Available']);
        return;
      }

      $text = '';
      foreach ($sessions as $session) {
          $text .= sprintf('*%s* - %s'.PHP_EOL, $session->name, $session->address);
          $text .= sprintf('Availability - Dose 1: *%s*'.PHP_EOL, $session->available_capacity_dose1);
          $text .= sprintf('Availability - Dose 2: *%s*'.PHP_EOL, $session->available_capacity_dose2);
          $text .= sprintf('Vaccine: *%s*'.PHP_EOL, $session->vaccine);
          $text .= sprintf('Min Age: *%s*'.PHP_EOL, $session->min_age_limit);
          $text .= sprintf('Fees: *%s*'.PHP_EOL, $session->fee_type);
          $text .= PHP_EOL;
      }

      $this->replyWithMessage(['text' => $text, 'parse_mode' => 'Markdown']);
      
    }
}
