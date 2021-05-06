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
    // return $router->app->version();
    return "Developed by Sidharth Menon";
});

$router->post('/'.config('telegram.route').'/webhook', function () {
    $update = Telegram::commandsHandler(true);
    
    return 'ok';
});
