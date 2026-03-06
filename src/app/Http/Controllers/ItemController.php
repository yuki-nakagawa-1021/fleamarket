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
        $items = Item::query()->with('order')->get();

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

        return redirect("/");
    }

    public function updateImage(Request $request, Item $item)
    {
        $data = $request->only(['name', 'brand_name', 'description', 'price', 'condition']);

        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }

        $path = $request->file('image')->store('items', 'public');
        $data['image_path'] = $path;

        $item->update($data);

        $item->categories()->sync($request->categories ?? []);

        return redirect("/items/{$item->id}");
    }

    public function show($item_id)
    {
        $item = Item::find($item_id);

        return view('items.show', compact('item'));
    }
}
