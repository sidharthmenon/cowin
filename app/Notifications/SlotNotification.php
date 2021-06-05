<?php

namespace App\Notifications;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class SlotNotification extends Notification implements ShouldQueue
{

  use Queueable;

  public $sessions, $date;
  
  public function __construct($sessions, $date)
  {
    $this->sessions = $sessions;
    $this->date = $date;
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
    
    $text = 'Slot Available on *'.$this->date.'*'.PHP_EOL;

    foreach ($this->sessions as $session) {
        $text .= sprintf('*%s* - %s'.PHP_EOL, $session->name, $session->address);
        $text .= sprintf('Availability - Dose 1: *%s*'.PHP_EOL, $session->available_capacity_dose1);
        $text .= sprintf('Availability - Dose 2: *%s*'.PHP_EOL, $session->available_capacity_dose2);
        $text .= sprintf('Vaccine: *%s*'.PHP_EOL, $session->vaccine);
        $text .= sprintf('Min Age: *%s*'.PHP_EOL, $session->min_age_limit);
        $text .= sprintf('Fees: *%s*'.PHP_EOL, $session->fee_type);
        $text .= PHP_EOL;
    }

    return TelegramMessage::create()
      ->content($text);

  }

  public function toMail($notifiable){
   
  }

}
