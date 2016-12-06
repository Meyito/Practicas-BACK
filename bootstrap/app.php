<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

 $app->withFacades();
 $app->configure('jwt'); 
 $app->configure('auth');
 $app->configure('excel');


if (!class_exists('Config')) {
    class_alias('Illuminate\Support\Facades\Config', 'Config');
}

if (!class_exists('Response')) {
    class_alias('Illuminate\Support\Facades\Response','Response');
}

if (!class_exists('Excel')) {
    class_alias('Maatwebsite\Excel\Facades\Excel', 'Excel');
}

if (!class_exists('JWTAuth')) {
    class_alias(Tymon\JWTAuth\Facades\JWTAuth::class, 'JWTAuth');
}

if (!class_exists('JWTFactory')) {
    class_alias(Tymon\JWTAuth\Facades\JWTFactory::class, 'JWTFactory');
}

 $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
        Illuminate\Contracts\Routing\ResponseFactory::class,
        Illuminate\Routing\ResponseFactory::class
);

$app->singleton(
        Illuminate\Auth\AuthManager::class,
        function ($app) {
    return $app->make('auth');
}
);

$app->singleton(
        Illuminate\Cache\CacheManager::class,
        function ($app) {
    return $app->make('cache');
}
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    //App\Http\Middleware\ExampleMiddleware::class
    App\Http\Middleware\Preflight::class,
    palanik\lumen\Middleware\LumenCors::class,
    App\Http\Middleware\AuthenticationMiddleware::class
 ]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'preflight' => App\Http\Middleware\Preflight::class,
    'jwt-auth' => App\Http\Middleware\JWTAuthentication::class
 ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class);
$app->register('Maatwebsite\Excel\ExcelServiceProvider');
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers\V1'], function ($app) {
    require __DIR__.'/../app/Http/routes.php';
});

return $app;
