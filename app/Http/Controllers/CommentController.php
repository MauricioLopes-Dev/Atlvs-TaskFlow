<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $task->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Comentário adicionado!');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();
        return back()->with('success', 'Comentário excluído!');
    }
}
