<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Http\Request;
use Auth;

class TagRepository
{

    function create(Request $request): Tag|Null
    {
        $tag = new Tag();
        $tag->created_by = Auth::user()->id;
        $tag->name = $request->name;
        $tag->color = $request->color;

        if ($tag->save()) {
            return $tag;
        }

        return null;
    }

    public function getTags(Request $request)
    {
        $tags = Tag::where(function ($query) {
            $query->where('created_by', Auth::user()->id);
        });
        $take = 10;

        if ($request->has('search')) {
            $tags->where('name', 'LIKE', '%' . $request->search . '%');
            $take = null;
        }

        if ($take > 0) {
            $tags->take($take);
        }

        return $tags->get();
    }

    public function getPaginatedTags(Request $request)
    {
        return Tag::where('created_by', Auth::user()->id)->paginate($request->perPage ?? 15);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::where('created_by', Auth::user()->id)->find($id);

        if ($tag) {
            $tag->name = $request->name;
            $tag->color = $request->color;

            if ($tag->save()) {
                return $tag;
            }
        }

        return null;
    }

    public function delete($id)
    {
        $tag = Tag::where('created_by', Auth::user()->id)->find($id);

        if ($tag && $tag->delete()) {
            return $tag;
        }

        return null;
    }
}
