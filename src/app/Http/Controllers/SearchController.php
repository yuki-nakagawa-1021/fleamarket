<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $items = Item::keywordSearch($request->keyword)->get();

        return view('index', compact('items'));
    }

}
