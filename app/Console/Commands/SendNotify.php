<?php

namespace App\Console\Commands;

use App\Notifications\UserNotification;
use App\User;
use Illuminate\Console\Command;

/**
 * Class KeyGenerateCommand
 * @package App\Console\Commands
 */
class SendNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send notification to users";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

      $users = User::all();

      $text  = "*Dear Subscriber*\n\n";
      $text .= "Hope you are safe.\n\n";
      $text .= "Our system has been updated to show Dose 1 and Dose 2 Availablity seperatly.\n\n";
      $text .= "You can subscribe to your preferred district using `/subscribe` option.\n\n";
      $text .= "For more details use `/help` option.\n\n";
      $text .= "Do share the link to this bot with friends and family t.me/CovinBot \n";
      
      foreach($users as $user){
        $user->notify(new UserNotification($text));
      }

    }

}