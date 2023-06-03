<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{

        public function index()
    {
        return view('users.index', [
            'users' => User::paginate(4)
        ]);
    }

/**
    * Devuelve la vista del formulario para crear un user. If successfull retorna el view asociativo con el mensaje de user.
    * 
    * 
    */
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'bio' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // Create user
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->bio = $request->bio;
    
        // Check if profile image was uploaded
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/profile_images', $filename);
            $user->profile_image = $filename;
        }
    
        $user->save();
    
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
    
    

    /**
    * Devuelve la vista del usuario en formato html. Si el nuevo user tiene que hay algun asignado se encuentra el archivo de fichero y enlace la url correspondiente
    * 
    * @param $user
    * 
    */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    
    /**
    * Show the form for editing the specified resource. GET / users / { id } / edit. php
    * 
    * @param $user
    * 
    */
    public function editUser(User $user)
    {
        $currentPhoto = $user->profile_image;
        
        return view('users.edit',compact('user', 'currentPhoto'));
    }
    /**
    * Update a user in the database. This is a form that allows to update an existing user from the data sent to the client
    * 
    * @param $request
    * @param $id
    * 
    */
    public function updateUser(Request $request, User $user)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255,' . $user->id,
            'email' => 'required|string|email|max:255,' . $user->id,
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

        return redirect()->route('users.index')->with('success', 'User updated');
    }
    /**
    * Remove the specified user from storage. DELETE / users / { id } Response will be redirected to the index page.
    * 
    * @param $user
    * 
    * @return The user that was deleted or a redirect to the index page if the user couldn't be found
    */
    public function destroy(User $user)
    {
        $user->delete();
    
        return redirect()->back()->with('success', 'User deleted successfully');
    }
    

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

        return redirect()->route('myprofile.index')->with('success', 'Profile updated.');
    }

    public function showProfile($username)
    {
        // Obtener el usuario por su nombre de usuario
        $user = User::where('username', $username)->firstOrFail();
    
        // Obtener los posts del usuario ordenados por fecha descendente
        $posts = $user->posts;
        $numPosts = $user->posts()->count();
        $numFollowers = $user->followers()->count();
        $numFollowing = $user->followings()->count();
        $profile_image = $user->profile_image;
    
        // Obtener la lista de seguidores y seguidos del usuario
        $followers = $user->followers()->get();
        $following = $user->followings()->get();
    
        // Verificar si el usuario autenticado sigue a alguien
        $isFollowing = false;
        if (auth()->check()) {
            $isFollowing = auth()->user()->following ? auth()->user()->following->contains($user->id) : false;
        }
    
        return view('users.profile', compact('user', 'posts', 'numPosts', 'numFollowers', 'numFollowing', 'profile_image', 'isFollowing', 'followers', 'following'));
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
