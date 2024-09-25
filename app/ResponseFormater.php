<?php

namespace App;
/**
 * Format response.
 */
class ResponseFormater
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'code' => 0,
        'status' => 'success',
        'message' => null,
        'data' => null,
        'total_data' => null
    ];

    /**
     * Give success response.
     */
    public static function success($responseCode, $data = null, $message = null, $total_data = null)
    {
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        self::$response['total_data'] = $total_data;

        return response()->json(self::$response, $responseCode);
    }

    /**
     * Give error response.
     */
    public static function error($responseCode, $data = null, $message = null, $code = 99)
    {
        self::$response['status'] = 'error';
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, $responseCode);
    }
}