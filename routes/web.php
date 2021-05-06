<?php

use App\Jobs\CheckDistrict;
use App\Subscription;
use App\User;
use Telegram\Bot\Laravel\Facades\Telegram;
use Ixudra\Curl\Facades\Curl;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/d83ca690-8457-469b-a1b8-0fcb084e02a6/webhook', function () {
    $update = Telegram::commandsHandler(true);
    
    return 'ok';
});

// $router->get('check/{code}', function($code){
//     dispatch(new CheckDistrict($code));
// });

// $router->get('subscriptions', function(){
//     // $user = User::first();
//     // $subscription = Subscription::firstOrCreate([
//     //     'district' => 2,
//     //     'user_id' => $user->id
//     // ]);

//     // $user = new User();
//     // $user->name = "test";
//     // $user->telegram_id = 1;
//     // $user->save();

//     // $subscription = new Subscription();
//     // $subscription->district = 303;
//     // $subscription->user_id = $user->id;
//     // $subscription->save();

//     $subs = Subscription::select('district')->distinct()->get();

//     // $subs = Subscription::all();
//     dd($subs);
// });

// $router->get('district/{code}', function($code){
//     $response = Curl::to('https://cdn-api.co-vin.in/api/v2/admin/location/districts/'.$code)
//                     ->withHeader('User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:88.0) Gecko/20100101 Firefox/88.0')
//                     ->asJson()
//                     ->get();

//                     dd($response);

//     $districts = $response->districts;

//     $text = '';
//     foreach ($districts as $district) {
//         $text .= sprintf('/slot %s - %s'.PHP_EOL, $district->district_id, $district->district_name);
//     }

//     dd($text);
// });

// $router->get('states', function(){
//     $response = Curl::to('https://cdn-api.co-vin.in/api/v2/admin/location/states')
//                     ->withHeader('User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:88.0) Gecko/20100101 Firefox/88.0')
//                     ->asJson()
//                     ->get();

//     $states = $response->states;

//     $text = '';
//     foreach ($states as $state) {
//         $text .= sprintf('/district %s - %s'.PHP_EOL, $state->state_id, $state->state_name);
//     }
//     dd($text);
// });