<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{

    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::user()->user_type === User::SUPER_ADMIN) {
            return $next($request);
        }

        return response()->json([
            'status'  => false,
            'message' => "Unauthorized! Super admin access only.",
            'data'    => []
        ], 401);
    }
}
