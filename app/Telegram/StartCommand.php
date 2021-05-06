<?php

namespace App\Telegram;

use App\User;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Enter /start <your name> to get started";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
      if(!$arguments){
        $this->replyWithMessage(['text' => 'Enter /start <your name> to start']);
        $this->triggerCommand('help');
        return;
      }

      $update = $this->getUpdate();

      $user = User::firstOrCreate(
        [ 'telegram_id' => $update["message"]["chat"]["id"] ], 
        [ 'name' => $arguments ]
      );

      $this->replyWithMessage(['text' => 'Hello '.$arguments]);
      $this->triggerCommand('help');

    }
}