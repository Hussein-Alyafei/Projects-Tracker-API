<?php

namespace App\Exceptions\Api;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiExceptions
{
    /**
     * Array mapping exception classes to their respective handler methods.
     */
    public static array $handlers = [
        AuthenticationException::class => 'handleAuthentication',
        ValidationException::class => 'handleValidation',
        ModelNotFoundException::class => 'handleModelNotFound',
        NotFoundHttpException::class => 'handleModelNotFound',
    ];


    /**
     * Handle AuthenticationException by returning a JSON response.
     *
     * @param AuthenticationException $exception The exception instance.
     * @param Request $request The request object.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function handleAuthentication(AuthenticationException $exception, Request  $request)
    {
        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => 401,
                'message' => $exception->getMessage()
            ]
        ]);
    }


    /**
     * Handle ValidationException by returning an array of errors.
     *
     * @param ValidationException $exception The exception instance.
     * @param Request $request The request object.
     * @return array
     */
    public static function handleValidation(ValidationException $exception, Request  $request)
    {
        // Iterate through validation errors and build error array
        foreach ($exception->errors() as $key => $value) {
            // Add each validation error to the errors array
            foreach ($value as $message) {
                $errors[] = [
                    'type' => basename(get_class($exception)),
                    'status' => 422,
                    'message' => $message,
                ];
            }
        }
        return $errors;  // Return the array of validation errors
    }

    
    /**
     * Handle ModelNotFoundException or NotFoundHttpException by returning a JSON response.
     *
     * @param ModelNotFoundException|NotFoundHttpException $exception The exception instance.
     * @param Request $request The request object.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function handleModelNotFound(ModelNotFoundException|NotFoundHttpException $exception, Request $request)
    {
        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => 404,
                'message' => 'Not Found ' . $request->getRequestUri()
            ]
        ]);
    }
}
