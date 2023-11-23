<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\ApiResponseBuilder;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerSignUpRequest;
use App\Http\Requests\UpdatePasswordRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $user->__set('roles', $user->roles);

        return ApiResponseBuilder::asSuccess()->withData($user)->build();
    }
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $userService = new UserService;
        $resp = $userService->chnagePassword($request);
        return
            $resp['status'] ?
            ApiResponseBuilder::asSuccess()->build() :
            ApiResponseBuilder::asError(429)->withMessage($resp['message'])->build();
    }

    function customerSignup(CustomerSignUpRequest $request)
    {
        $userService = new UserService;
        $user = $userService->signupCustomer($request);
        return
            $user ?
            ApiResponseBuilder::asSuccess()->withData($user)->build() :
            ApiResponseBuilder::asError(429)->withMessage("There is a problem while signing up.")->build();
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userService = new UserService;
        $user = $userService->signupCustomer($request);
        return
            $user ?
            ApiResponseBuilder::asSuccess()->withData($user)->build() :
            ApiResponseBuilder::asError(429)->withMessage("There is a problem while signing up.")->build();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
