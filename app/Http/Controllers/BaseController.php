<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{

    protected function responseJson($status = true, $responseCode = 200, $message = "", $data = [])
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
            ], $responseCode);
    }
}
