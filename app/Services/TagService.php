<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\TagRepository;
use Auth;
use Illuminate\Http\Request;

class TagService
{
    public function getDefiniteTags(Request $request)
    {

        return (new TagRepository)->getTags($request);
    }

    public function getPaginatedTags(Request $request)
    {
        return (new TagRepository)->getPaginatedTags($request);
    }

    public function createTag(Request $request): Tag|null
    {

        return (new TagRepository)->create($request);
    }

    public function updateTag(Request $request, $id): Tag|null
    {

        return (new TagRepository)->update($request, $id);
    }

    public function delete($id): Tag|Null
    {
        return (new TagRepository)->delete($id);
    }
}
