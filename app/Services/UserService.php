<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function chnagePassword(Request $request)
    {
        $resp = ['status' => false, 'message' => 'There is a problem while updating password.'];
        #Match The Old Password
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return false;
            $resp['mesage'] = "Invalid Current Password";
        }
        $resp['status'] = (new UserRepository)->updatePasword($request);
        return $resp;
    }

    function signupCustomer(Request $request)
    {
        return (new UserRepository)->createCustomerAndAssignRole($request);
    }
}