<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            $posts = Post::with('likes')->whereNull('deleted_at')->paginate(8);
        } else {
            $userIds = $user->followings()->pluck('users.id')->toArray();
            array_push($userIds, $user->id);
            $posts = Post::with('likes')
                ->whereIn('user_id', $userIds)
                ->whereNull('deleted_at')
                ->orderByDesc('created_at') // Ordena las publicaciones más recientes primero
                ->paginate(8);
        }
    
        $users = [];
        foreach ($posts as $post) {
            $user = User::select('username')->where('id', $post->user_id)->value('username');
            $users[$post->id] = $user;
        }
    
        return view('posts.index', compact('posts', 'users'));
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
        $post->user_id = auth()->user()->id; // Asignar el ID del usuario autenticado
        $post->save();

        return redirect()->route('posts')->with('success', 'Post created successfully.');
    }

    public function show($id)
    {
        $post = Post::with('comments')->findOrFail($id);
        $user = User::findOrFail($post->user_id);

        return view('posts.show', compact('post', 'user'));
    }


    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $currentPhoto = $post['photo'];
        $user = User::where('id', $post->user_id)->value('username');

        return view('posts.edit', compact('post', 'currentPhoto', 'user'));
    }


    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        $post->description = $request->input('description');
        $post->user_id = $request->input('user_id');

        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images'), $imageName);
            $post->photo = $imageName;
        }

        $post->save();

        return redirect()->route('posts')->with('success', 'Post updated successfully.');
    }


public function destroy(Post $post)
{
    $post->delete();

    return redirect()->back()->with('success', 'Post deleted successfully.');
}


}
