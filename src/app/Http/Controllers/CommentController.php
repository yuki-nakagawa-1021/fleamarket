<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $item_id)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'body' => $request->comment,
        ]);

        // リダイレクトでOK：showがwithCountしてるからコメント数は増える
        return redirect("/item/{$item_id}");
    }
}