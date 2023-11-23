<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\ApiResponseBuilder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\CustomerInfoService;
use Auth;

class CustomerInfoController extends Controller
{
    public function getCustomerProfile(Request $request)
    {
        $id = $request->has('id') ? $request->id : '';
        $customerInfoService = new CustomerInfoService;
        $data = $customerInfoService->getCustomerInfo($id);
        return
            $data ?
            ApiResponseBuilder::asSuccess()->withData($data)->build() :
            ApiResponseBuilder::asError(429)->withMessage("There is a problem while getting customer profile.")->build();
    }

    public function updateProfile(Request $request)
    {
        $id = $request->has('id') ? $request->id : Auth::id();
        $profileService = new CustomerInfoService;
        $resp = $profileService->updateCustomerProfile($request, $id);
        return
            $resp ?
            ApiResponseBuilder::asSuccess()->withData($resp)->build() :
            ApiResponseBuilder::asError(429)->withMessage("There is a problem while updating profile.")->build();
    }

    public function uploadProfilePicture(Request $request)
    {
        if ($request->has('media')) {
            $file = $request->media;
            list($type, $file) = explode(';', $file);
            list(, $file)      = explode(',', $file);
            $file = base64_decode($file);
            $name = Str::uuid() . '.' . explode('/', mime_content_type($request->media))[1];
            if (Storage::disk('profile')->put($name, $file)) {
                $url = Storage::disk('profile')->url($name);
                $profileService = new CustomerInfoService;
                $profileService->updateProfilePicture($url);

                return ApiResponseBuilder::asSuccess()->withData([
                    'url' => $url,
                    'name' => $name
                ])->build();
            }
        } else {
            return ApiResponseBuilder::asSuccess()->withData([])->build();
        }
    }
}
