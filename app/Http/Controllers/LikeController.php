<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $user = auth()->user();

        // Check if the user has already liked the post
        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // If the user has already liked the post, remove the like
            $existingLike->delete();
        } else {
            // If the user has not liked the post, create a new like
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        }

        // Redirect to the posts index page after the like action
        return redirect()->route('posts.index');
    }
}
