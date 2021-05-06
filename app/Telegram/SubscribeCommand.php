<?php

namespace App\Telegram;

use App\Subscription;
use App\Traits\HasUser;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Ixudra\Curl\Facades\Curl;
use Telegram\Bot\Laravel\Facades\Telegram;

class SubscribeCommand extends Command
{
  use HasUser;
  /**
   * @var string Command Name
   */
  protected $name = "subscribe";

  /**
   * @var string Command Description
   */
  protected $description = "Enter /subscribe <district code> to get notification";

  /**
   * @inheritdoc
   */
  public function handle($arguments)
  {
    if($arguments){
      $district = explode(" ", $arguments)[0];
    }
    else{
      $this->replyWithMessage(['text' => 'District code not found. Enter /subscribe <district code>']);
      $this->triggerCommand('help');
      return;
    }
    
    $this->replyWithChatAction(['action' => Actions::TYPING]);


    $user = $this->_get_user();
    
    if($user){

      $subscription = Subscription::firstOrCreate([
        'district' => $district,
        'user_id' => $user->id
      ]);

      $this->replyWithMessage(['text' => 'Subscription activated']);

      $this->triggerCommand('slot');
    }
    else{
      $this->replyWithMessage(['text' => 'Use /start <your name> to get started']);
      return;
    }

  }

}
