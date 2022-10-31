<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{

    public function index(): JsonResponse
    {
        $users = User::where('user_type', '=', User::USER)->get();
        return $this->responseJson(true, 200, 'Users retrieved!', ['users' => $users]);
    }

}
