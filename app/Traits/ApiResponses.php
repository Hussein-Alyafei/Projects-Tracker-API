<?php

namespace App\Traits;

trait ApiResponses
{
    /**
     * Return a JSON response.
     *
     * @param string $message The message.
     * @param array $data The data to include in the response.
     * @param int|null $statusCode The HTTP status code to use for the response.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response($message, $data = [], $statusCode = 200)
    {
        $responseData = [
            'status' => $statusCode,
            'message' => $message,
        ];

        if (!empty($data)) {
            $responseData['data'] = $data;
        }

        return response()->json($responseData, $statusCode);
    }

    /**
     * Return a successful response with a 200 status code.
     *
     * @param string $message The success message.
     * @param array $data The additional data to include in the response.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function ok($message, $data = [])
    {
        return $this->response($message, $data, 200);
    }

    /**
     * Return an error response.
     *
     * @param mixed $errors The error message or array of errors.
     * @param int|null $statusCode The HTTP status code to use for the response.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($errors = [], $statusCode = null)
    {
        if (is_string($errors)) {
            return $this->response($errors, [], $statusCode);
        }

        return response()->json([
            'errors' => $errors
        ]);
    }

    /**
     * Return a "not authorized" response with a 401 status code.
     *
     * @param string $message The error message.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function notAuthorized($message)
    {
        return $this->error([
            'status' => 401,
            'message' => $message,
        ]);
    }
}
