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
    if (Auth::user()->isAdmin()) {
        $posts = Post::paginate(8);
    } else {
        $userIds = Auth::user()->followings()->pluck('users.id')->toArray();
        array_push($userIds, Auth::id());
        $posts = Post::whereIn('user_id', $userIds)->paginate(5);
    }

    $users = [];
    foreach ($posts as $post) {
        $user = User::select('username')->where('id', $post->user_id)->value('username');
        $users[$post->id] = $user;
    }

    // Obtén la cantidad de likes de cada post
    $likesCount = [];
    foreach ($posts as $post) {
        $likesCount[$post->id] = $post->likes()->count();
    }

    return view('posts.index', compact('posts', 'users', 'likesCount'));
}


    public function create()
    {
        return view('posts.create');
    }

    public function like(Request $request)
    {
        $postId = $request->input('post_id');
        $userId = Auth::id(); // Obtén el ID del usuario actualmente autenticado
    
        // Verifica si el usuario ya ha dado like a este post
        $existingLike = Like::where('user_id', $userId)->where('post_id', $postId)->first();
    
        if ($existingLike) {
            // El usuario ya ha dado like, puedes manejarlo de la forma que desees (por ejemplo, mostrar un mensaje de error)
            return response()->json(['message' => 'Ya has dado like a esta publicación.']);
        }
    
        // Crea un nuevo like
        $like = new Like();
        $like->user_id = $userId;
        $like->post_id = $postId;
        $like->save();
    
        // Incrementa la cantidad de likes en el post
        $post = Post::find($postId);
        $post->likes_count++;
        $post->save();
    
        // Obtén la cantidad de likes actualizada
        $likesCount = $post->likes_count;
    
        // Retorna la cantidad de likes actualizada en formato JSON
        return response()->json(['likesCount' => $likesCount]);
        
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

        // dd($post->id);
        return view('posts.edit', compact('post', 'currentPhoto', 'user'));
    }


    public function update(Request $request, Post $post)
    {
        $request->validate([
            'photo' => 'image|max:2048',
            'description' => 'required',
        ]);
    
        $post->description = $request->description;
        $post->user_id = $request->user_id;
    
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
    
        // Verificar si se ha dado like
        if ($request->has('like')) {
            // Realizar las operaciones necesarias para agregar el like en la base de datos
    
            // Por ejemplo, puedes hacer lo siguiente:
            $user = Auth::user();
            $post->likes()->attach($user->id);
        }
    
        return redirect()->route('posts')->with('success', 'Post updated successfully.');
    }
    


    public function destroy(Post $post) //me borra siempre el ultimo...
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
