<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use Auth;



class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        
        if(!Auth::attempt($request->only('email','password'))){
            Helper::sendError('email ou mode passe sont incorrectes');
        }

        return new UserResource(auth()->user());
    }
}
