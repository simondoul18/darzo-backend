<?php

namespace App\Repositories;

use App\Models\CustomerInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class UserRepository
{
    public function updatePasword($request)
    {
        $user = User::whereId(Auth::user()->id)->first();
        if (!empty($user)) {
            $user->password = Hash::make($request->password);
            return $user->save() ? true : false;
        }
        return false;
    }

    function createCustomerAndAssignRole(Request $request): User | null
    {
        $transaction = DB::transaction(function () use ($request) {
            $customer = new User;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->password = $request->password;

            if ($customer->save() && $this->createCustomerInfo($customer, $request)) {
                //AssignRole
                if ($this->assignCustomerRole($customer)) {
                    return $customer;
                }
            }
            return null;
        });

        return $transaction;
    }

    function createCustomerInfo(User $user, Request $request): CustomerInfo | null
    {

        if ($user) {
            //Create Customer Info
            $customerInfo = new CustomerInfo;
            $customerInfo->user_id = $user->id;
            $customerInfo->profile_pic = $request->profile_pic;
            $customerInfo->phone = $request->phone;
            $customerInfo->gender = $request->gender;
            $customerInfo->bio = $request->bio;
            $customerInfo->dob = $request->dob;

            if ($customerInfo->save()) {
                return $customerInfo;
            }
        } else {
            throw ("The Supplied user is incompatible.");
        }

        return null;
    }

    function assignCustomerRole(User $user): User | null
    {
        if (!$user->hasRole(User::CUSTOMER_ROLE, 'api')) {
            $user->assignRole(User::CUSTOMER_ROLE);
            return $user;
        }

        return null;
    }
}
