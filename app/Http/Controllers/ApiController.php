<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected function ApiResponse($statusCode = 200, $message = "success", $data)
    {
        return response()->json([
            "success" => $statusCode < 400 ? true : false,
            "statusCode" => $statusCode,
            "message" => $message,
            "data" => $data
        ], $statusCode);
    }

    protected function ApiError($statusCode = 500, $message = "Something went wrong")
    {
        $statusCode = $statusCode < 400 ? 500 : $statusCode;
        return response()->json([
            "success" => false,
            "statusCode" => $statusCode,
            "message" => $message
        ], $statusCode);
    }
}
