<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('myprofile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update user profile
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->bio = $request->bio;

        // Check if profile image was uploaded
        if ($request->hasFile('profile_image')) {
            // Delete previous profile image
            if ($user->profile_image) {
                Storage::delete('public/profile_images/' . $user->profile_image);
            }

            // Save new profile image
            $image = $request->file('profile_image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/profile_images', $filename);
            $user->profile_image = $filename;
        }

        $user->save();

        return redirect()->route('myprofile.index')->with('success', 'Perfil actualizado correctamente.');
    }

    public function showProfile($username)
    {
        // Obtener el usuario por su nombre de usuario
        $user = User::where('username', $username)->firstOrFail();
    
        // Obtener los posts del usuario ordenados por fecha descendente
        $posts = $user->posts;
        $posts = $user->posts;
        $numPosts = $user->posts()->count();
        $numFollowers = $user->followers()->count();
        $numFollowing = $user->followings()->count();
        $profile_image = $user->profile_image;
    
        // Verificar si el usuario autenticado sigue a alguien
        $isFollowing = false;
        if (auth()->check()) {
            $isFollowing = auth()->user()->following ? auth()->user()->following->contains($user->id) : false;
        }

        return view('users.profile'
            // 'user' => $user,
            // 'posts' => $posts,
            // 'isFollowing' => $isFollowing
        , compact('user', 'posts', 'numPosts', 'numFollowers', 'numFollowing', 'profile_image', 'isFollowing'));
    }    

    public function followUser(Request $request)
    {
        // Obtener el ID del usuario a seguir
        $userId = $request->input('user_id');

        // Obtener el usuario a seguir
        $user = User::findOrFail($userId);

        // Seguir al usuario si no se está siguiendo ya
        if (!auth()->user()->following->contains($userId)) {
            auth()->user()->following()->attach($userId);
        }

        return redirect()->route('user.profile', ['username' => $user->username])
            ->with('success', 'Now following ' . $user->username);
    }
}
