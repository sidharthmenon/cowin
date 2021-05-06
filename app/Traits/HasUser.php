<?php

namespace App\Traits;

use App\User;

trait HasUser{

  public function _get_user(){
    $update = $this->getUpdate();
    return User::where('telegram_id', $update["message"]["chat"]["id"])->first();
  }

}