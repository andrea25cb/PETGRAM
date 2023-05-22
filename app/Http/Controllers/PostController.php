<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $posts = Post::paginate(8);
        } else {
            $userIds = Auth::user()->followings()->pluck('users.id')->toArray();
            array_push($userIds, Auth::id());
            $posts = Post::whereIn('user_id', $userIds)->paginate(5);
        }
    
        // $username = User::select('username')->where('id','=', 1)->get()
      
    
        return view('posts.index', compact('posts'));
    }
    
    


    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'description' => 'required',
        ]);

        $imageName = time() . '.' . $request->photo->extension();

        $request->photo->move(public_path('images'), $imageName);

        $post = new Post;
        $post->photo = $imageName;
        $post->description = $request->description;
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect()->route('posts')->with('success', 'Post created successfully.');
    }
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $currentPhoto = $post->photo;
        return view('posts.edit', compact('post', 'currentPhoto')); 
    }
    
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'photo' => 'image|max:2048',
            'description' => 'required',
        ]);
    
        $post->description = $request->description;
    
        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images'), $imageName);
            $post->photo = $imageName;
        }
    
        // Si no se selecciona una nueva imagen, mantén la actual
        else {
            $post->photo = $post->photo;
        }
    
        $post->save();
    
        return redirect()->route('posts')->with('success', 'Post updated successfully.');
    }
      
    
    public function destroy(Post $post)
    {
        if (Auth::user()->isAdmin() || Auth::id() == $post->user_id) {
            $post->delete();
            $post = Post::withTrashed()->get();
            return redirect()->route('posts')->with('success', __('Post deleted successfully.'));
        } else {
            abort(403);
        }
    }
    
}
