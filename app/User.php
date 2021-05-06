<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class User extends Model 
{
    use UsesUuid, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'telegram_id',
    ];

    public function routeNotificationForTelegram()
    {
        return $this->telegram_id;
    }

}
