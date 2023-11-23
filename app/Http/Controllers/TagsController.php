<?php

namespace App\Http\Controllers;

use App\Http\ApiResponseBuilder;
use App\Http\Requests\TagRequest;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tagsService = new TagService;
        $tags = $tagsService->getDefiniteTags($request);

        return ApiResponseBuilder::asSuccess()->withData($tags)->build();
    }

    public function paginated(Request $request)
    {
        $tagsService = new TagService;
        $tags = $tagsService->getPaginatedTags($request);

        return ApiResponseBuilder::asSuccess()->withData($tags)->build();
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
    public function store(TagRequest $request)
    {
        $tagsService = new TagService;
        $tag = $tagsService->createTag($request);

        return ApiResponseBuilder::asSuccess()->withData($tag)->build();
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
    public function update(TagRequest $request, string $id)
    {
        $tagsService = new TagService;
        $tag = $tagsService->updateTag($request, $id);

        return $tag ? ApiResponseBuilder::asSuccess()->withData($tag)->build() :
            ApiResponseBuilder::asError(204)->withData($tag)->build();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tagsService = new TagService;
        $tag = $tagsService->delete($id);

        return $tag ? ApiResponseBuilder::asSuccess()->withData($tag)->build() :
            ApiResponseBuilder::asError(204)->withData($tag)->build();
    }
}
