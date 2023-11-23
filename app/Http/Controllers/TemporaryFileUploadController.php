<?php

namespace App\Http\Controllers;

use App\Http\ApiResponseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemporaryFileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if ($request->has('media')) {
            $file = $request->media;
            [$type, $file] = explode(';', $file);
            [, $file] = explode(',', $file);
            $file = base64_decode($file);
            $name = Str::uuid().'.'.explode('/', mime_content_type($request->media))[1];
            if (Storage::disk('temp')->put($name, $file)) {
                $url = Storage::disk('temp')->url($name);

                return ApiResponseBuilder::asSuccess()->withData([
                    'url' => $url,
                    'name' => $name,
                ])->build();
            }
        } else {
            return ApiResponseBuilder::asSuccess()->withData([])->build();
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
