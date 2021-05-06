<?php

namespace App\Jobs;

use App\Notifications\SlotNotification;
use App\Subscription;
use DateTime;
use Ixudra\Curl\Facades\Curl;

class CheckDistrict extends Job
{

    public $district;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($district)
    {
        $this->district = $district;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = (new DateTime('now'))->format('d-m-Y');
        $tomorrow = (new DateTime('tomorrow'))->format('d-m-Y');

        $this->_check_date($today);
        $this->_check_date($tomorrow);
    }

    private function _check_date($date){

        $response = Curl::to('https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/findByDistrict')
            ->withData( [ 'district_id' => $this->district, 'date' => $date ] )
            ->withHeader('User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:88.0) Gecko/20100101 Firefox/88.0')
            ->asJson()
            ->get();

        $sessions = $response->sessions;

        if($sessions){
            $subscriptions = Subscription::where('district', $this->district)->get();
            foreach($subscriptions as $subscription){
                $subscription->user->notify(new SlotNotification($sessions, $date));
            }
        }

    }
}
