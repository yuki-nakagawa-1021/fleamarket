<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($item_id)
    {
        Like::Create([
            'item_id' => $item_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }

    public function unlike($item_id)
    {
        Like::where('item_id', $item_id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back();
    }
}