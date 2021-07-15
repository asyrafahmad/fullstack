<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class AdminController extends Controller
{
    public function addTag(Request $request)
    {
        //validate
        $create = Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }
}
