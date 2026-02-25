<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query()->with('order');

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        $items = $query->get();

        $mylistItems = collect();

        return view('items.index', compact('items', 'mylistItems'));
    }
}
