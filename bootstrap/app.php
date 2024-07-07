<?php

use App\Exceptions\Api\ApiExceptions;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $exception, Request  $request) {
            $className = get_class($exception);
            $handlers = ApiExceptions::$handlers;

            if (array_key_exists($className, $handlers)) {
                // If a specific handler method is defined for this exception class, invoke it
                $method = $handlers[$className];
                return ApiExceptions::$method($exception, $request);
            }
            
            // If no specific handler is defined, return a generic error response
            return response()->json([
                'error' => [
                    'type' => basename(get_class($exception)),
                    'status' => intval($exception->getCode()), // returns 0 if no code
                    'message' =>  $exception->getMessage()
                ]
            ]);
        });
    })->create();
