<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; 
use Illuminate\Session\Middleware\StartSession;
////  Bearer 53|iAjE7h7W2L3RYfloJ04xkd7otzd7etqgUWSIGbwI26ddede9
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    /*
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'mymiddle' => \App\Http\Middleware\mymiddle::class,
        ]);
    */    
        ->withMiddleware(function (Middleware $middleware) {
           // $middleware->statefulApi();
            $middleware->append(StartSession::class);
            $middleware->alias([
                'abilities' => CheckAbilities::class,
                'ability' => CheckForAnyAbility::class,
            ]);
          /*   
          $middleware->api(append:[
                \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
                \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ]);
      */
      })
   
        
       
    
        
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
