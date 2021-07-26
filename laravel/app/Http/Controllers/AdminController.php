<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Tag;
use App\Category;
use App\User;

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
        $this->deleteFileFromServer($fileName, false);

        return 'done delete image';
    }

    public function deleteFileFromServer($fileName, $hasFullPath = false)
    {
        if (!$hasFullPath) {
            // TODO: delete file from storage folder
            $filePath = public_path() . '/uploads/' . $fileName;
        }

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

    public function editCategory(Request $request)
    {
        //validate request
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);

        Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }

    public function deleteCategory(Request $request)
    {
        // first delete the original file from the server
        $this->deleteFileFromServer($request->iconImage);

        // validate request
        $this->validate($request, [
            'id' => 'required',
        ]);

        return Category::where('id', $request->id)->delete();
    }

    public function createUser(Request $request)
    {
        // validate  request
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'userType' => 'required',
        ]);

        $password = bcrypt($request->password);

        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'userType' => $request->userType,
        ]);

        return $user;
    }
    public function getUsers(Request $request)
    {
        return User::where('userType', '!=', 'User')->get();
    }
    public function editUser(Request $request)
    {
        //validate request
        $this->validate($request, [
            'fullName' => 'required',
            'email' => "bail|required|email|unique:users,email,$request->id",
            'password' => 'min:6',
            'userType' => 'required'
        ]);

        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'userType' => $request->userType
        ];

        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }

        $user = User::where('id', $request->id)->update($data);
        return $user;
    }

    public function adminLogin(Request $request)
    {
        //validate request
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'msg' => 'You are logged in',
            ]);
        } else {
            return response()->json([
                'msg' => 'Incorrect login details',
            ], 401);
        }
    }
}
