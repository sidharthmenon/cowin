<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class UserNotification extends Notification implements ShouldQueue
{

  use Queueable;

  public $text;

  public function __construct($text)
  {
    $this->text = $text;
  }


  public function via($notifiable)
  {
    if($notifiable->telegram_id){
      return [TelegramChannel::class];
    }
    else{
      return [];
    }
  }

  public function toTelegram($notifiable)
  {
    return TelegramMessage::create()
      ->content($this->text);
  }

}