<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|min:10',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment = new Comment();
        $comment->content = $validatedData['content'];
        $comment->post_id = $validatedData['post_id'];
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}
