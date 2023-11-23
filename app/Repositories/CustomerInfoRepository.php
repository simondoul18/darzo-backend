<?php

namespace App\Repositories;

use DB;
use App\Models\User;
use App\Models\CustomerInfo;
use Illuminate\Support\Facades\Auth;

class CustomerInfoRepository
{
    public function getProfile($id = '')
    {
        $user_id = empty($id) ? Auth::id() : $id;
        return User::select('id', 'uuid', 'name', 'email', 'created_at')->with(['customer', 'address'])->where('id', $user_id)->first();
    }
    public function update(array $details, $id): User | bool
    {
        $transaction = DB::transaction(function () use ($details, $id) {
            $user = User::where('id', $id)->first();
            if ($user) {
                $user->name = $details['name'];
                $user->email = $details['email'];
                $user->save();

                $resp = CustomerInfo::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'phone' => $details['phone'],
                        'gender' => $details['gender'],
                        'bio' => $details['bio'],
                        // 'dob' => empty($details['bio'])? null:$details['bio'],
                    ]
                );
                return true;
            }
        });
        return $transaction ? $transaction : false;
    }

    public function updateCustomerProfilePicture($url)
    {
        $user_id = Auth::id();
        CustomerInfo::where('user_id', $user_id)->update(['profile_pic' => $url]);
        return true;
    }
}
