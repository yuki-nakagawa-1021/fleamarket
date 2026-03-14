<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function create($item_id)
    {
        $item = Item::find($item_id);

        $user = auth()->user();

        return view('purchases.create', compact('item', 'user'));
    }

    public function store(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        Order::create([
            'item_id' => $item->id,
            'buyer_id' => $user->id,
            'payment_method' => $request->payment_method,
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        return redirect('/');
    }
}
