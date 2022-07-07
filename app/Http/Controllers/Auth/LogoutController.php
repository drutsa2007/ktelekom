<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\BaseController as BaseController;
use Illuminate\Http\Request;

class LogoutController extends BaseController
{
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json(['success' => true], 200);
    }
}
