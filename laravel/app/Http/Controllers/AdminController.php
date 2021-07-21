<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Category;

class AdminController extends Controller
{
    public function addTag(Request $request)
    {
        //validate request
        $this->validate($request, [
            'tagName' => 'required'
        ]);

        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function editTag(Request $request)
    {
        //validate request
        $this->validate($request, [
            'id' => 'required',
            'tagName' => 'required'
        ]);

        Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName
        ]);

        return response()->json([
            'tagName' => $request->tagName
        ]);
    }
    public function deleteTag(Request $request)
    {
        //validate request
        $this->validate($request, [
            'id' => 'required',
            'tagName' => 'required'
        ]);

        return Tag::where('id', $request->id)->delete();
    }

    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);

        $picName =  time() . '.' . $request->file->extension();
        // TODO: put in storage folder for more secure
        $request->file->move(public_path('uploads'), $picName);

        return $picName;
    }

    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName);

        return 'done delete image';
    }

    public function deleteFileFromServer($fileName)
    {
        // TODO: delete file from storage folder
        $filePath = public_path() . '/uploads/' . $fileName;

        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        return;
    }
    public function addCategory(Request $request)
    {
        //validate request
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);

        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }

    public function getCategories()
    {
        return Category::orderBy('id', 'desc')->get();
    }
}
