<?php

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

$app->get('/', function () use ($app) {
    return "Welcome to Meyito Backend :3";
});

$app->get('/key', function () {
    return str_random(32);
});

$app->group([
    'prefix' => 'api/v1',
    'middleware' => 'preflight',
    'namespace' => 'App\Http\Controllers\V1'
],
    function () use ($app) {
        $app->get("development-plans", "DevelopmentPlanController@index");
        $app->post("plan/upload", "DevelopmentPlanController@uploadPlan");
    });