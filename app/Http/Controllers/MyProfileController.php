<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MyProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $posts = $user->posts;
        $numPosts = $user->posts()->count();
        $numFollowers = $user->followers()->count();
        $numFollowing = $user->followings()->count();
        $profile_image = $user->profile_image;
        $following = $user->followings;
        $followers = $user->followers; // Agregar esta línea para obtener la lista de seguidores
    
        return view('myprofile.index', compact('user', 'posts', 'numPosts', 'numFollowers', 'numFollowing', 'profile_image', 'following', 'followers'));
    }
    

    public function edit()
    {
        $user = Auth::user();
        $currentPhoto = $user->profile_image;
        return view('myprofile.edit', compact('user', 'currentPhoto'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->bio = $request->input('bio');

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/profile_images', $filename);
            $user->profile_image = $filename;
        }

        $user->save();

        return redirect()->route('myprofile')->with('success', 'Profile updated successfully!');
    }
}
