<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
    public function validateToken($token)
    {
        if (!$token && $token != env('API_TOKEN')) {
            return false;
        }

        return true;
    }

    protected function errorResponse($errors = [])
    {
        if ($errors instanceof Arrayable) {
            $errors = $errors->toArray();
        }
        $messages = is_array($errors) ? $errors : [$errors];

        return response()->json(array('messages' => $messages), 400);
    }

    protected function successResponse($msg)
    {
        return response()->json(array('message' => $msg));
    }

    protected function emptyResponse()
    {
        return response()->json(array());
    }
}
