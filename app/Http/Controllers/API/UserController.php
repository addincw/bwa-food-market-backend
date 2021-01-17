<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\PasswordValidationRules;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Helpers\Api;
use App\Models\User;

class UserController extends Controller
{
    use PasswordValidationRules;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $authenticatedUser = Auth::user();
            return Api::response(200, 'user success loaded', ['user' => $authenticatedUser]);
        } catch (\Exception $th) {
            return Api::response(401, 'token expired');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newUserAction = new CreateNewUser();
        $newUser = $newUserAction->create($request->all());

        return Api::response(200, 'register new user success', [
            'user' => $newUser
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->user()->id != $id) {
            return Api::response(422, 'user id not match with authenticated user'); 
        }

        $UpdateProfileAction = new UpdateUserProfileInformation();
        $UpdateProfileAction->update($request->user(), $request->all());

        return Api::response(204, 'update user information success');
    }

    public function updateAddress(Request $request, $id)
    {
        if($request->user()->id != $id) {
            return Api::response(422, 'user id not match with authenticated user'); 
        }

        $request->validate([
            'address' => ['required', 'string'],
            'house_number' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
        ]);

        try {
            $authenticatedUser = $request->user();
            $authenticatedUser->update($request->only(
                'address', 
                'house_number', 
                'city', 
                'phone_number'
            ));

            return Api::response(204, 'update user information success');
        } catch (\Exception $th) {
            return Api::response(500, 'update user information failed: '.$th->getMEsage());
        }

    }
}
