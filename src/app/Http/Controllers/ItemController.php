<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        if ($request->tab) {
            $tab = $request->tab;
        }
        else {
            $tab = 'recommend';
        }

        $items = Item::with('order')->keywordSearch($keyword)->latest()->get();

        return view('items.index', compact('items', 'keyword', 'tab'));
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        $items = Item::query()->with('order')->keywordSearch($keyword)->when(Auth::check(), function ($query) {
            $query->where('user_id', '!=', Auth::id());
        })->get();

        $mylistItems = collect();

        if (Auth::check()) {
            $mylistItems = Item::query()->with('order')->where('user_id', '!=', Auth::id())->whereHas('likes', function ($query)
            {
                $query->where('user_id', Auth::id());
            })->keywordSearch($keyword)->get();
        }

        return view('items.index', compact('items', 'mylistItems', 'tab', 'keyword'));
    }

    public function create()
    {
        $categories = Category::all();
        $item = new Item();

        return view('items.create', compact('categories', 'item'));
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->only(['name', 'brand_name', 'description', 'price', 'condition']);
        $data['user_id'] = Auth::id();

        $path = $request->file('image')->store('items', 'public');
        $data['image_path'] = $path;

        $item = Item::create($data);

        $item->categories()->attach($request->categories);

        return redirect("/");
    }

    public function show($item_id)
    {
        $item = Item::with(['categories', 'comments.user'])
            ->withCount(['likes', 'comments'])
            ->findOrFail($item_id);

        return view('items.show', compact('item'));
    }
}
