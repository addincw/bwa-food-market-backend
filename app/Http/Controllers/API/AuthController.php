<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Api;
use App\Models\User;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $validator = $request->validate([
            'username' => 'email|required',
            'password' => 'required'
        ]);

        if (Auth::attempt([
                'email' => $request->username, 
                'password' => $request->password,
                'role' => User::ROLE_USER
            ])) {
            $authenticatedUser = Auth::user();
            $token = $authenticatedUser->createToken('user_access_token_'.$authenticatedUser->id);

            return Api::response(200, 'user authenticated', [
                'access_token' => $token->plainTextToken,
                'user' => $authenticatedUser
            ]);
        }

        return Api::response(401, 'username / password invalid');
    }
    public function signout()
    {
        $authenticatedUser = Auth::user();
        $authenticatedUser->tokens()->delete();

        return Api::response(204, '');
    }
    public function resetPassword()
    {
    }
}
