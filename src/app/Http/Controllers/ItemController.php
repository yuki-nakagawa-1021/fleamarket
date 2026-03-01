<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Storage;

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

    public function create()
    {
        $categories = Category::all();
        $item = new Item();

        return view('items.create', compact('categories', 'item'));
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->only(['name', 'brand_name', 'description', 'price', 'condition']);
        $data['user_id'] = auth()->id();

        $path = $request->file('image')->store('items', 'public');
        $data['image_path'] = $path;

        $item = Item::create($data);

        $item->categories()->attach($request->categories);

        return redirect()->route('items.show', $item);
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function updateImage(Request $request, Item $item)
    {
        $data = $request->only(['name', 'brand_name', 'description', 'price', 'condition']);
        $data['user_id'] = auth()->id();

        $path = $request->file('image')->store('items', 'public');
        $data['image_path'] = $path;

        $item = Item::create($data);

        $item->categories()->attach($request->categories);

        return redirect()->route('items.show', $item);
    }
}
