<?php namespace App\Helpers;

class Api
{
    public static function response($statusCode = 200, $message = '', $data = null)
    {
        $response = ['message' => $message];
        
        ($statusCode < 400)
            ? $response['data'] = $data
            : $response['errors'] = $data;

        return response()->json($response, $statusCode);
    }
}
