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

        $shippingAddress = session('purchase_address.' . $item_id, [
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        return view('purchases.create', compact('item', 'user', 'shippingAddress'));
    }

    public function store(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        $shippingAddress = session('purchase_address.' . $item_id, [
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        Order::create([
            'item_id' => $item->id,
            'buyer_id' => $user->id,
            'payment_method' => $request->payment_method,
            'postal_code' => $shippingAddress['postal_code'],
            'address' => $shippingAddress['address'],
            'building' => $shippingAddress['building'],
        ]);

        return redirect('/');
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        $shippingAddress = session('purchase_address.' . $item_id, [
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        return view('purchases.address', compact('item', 'user', 'shippingAddress'));
    }

    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'postal_code' => ['required', 'max:8'],
            'address' => ['required', 'max:255'],
            'building' => ['nullable', 'max:255'],
        ]);

        session([
            'purchase_address.' . $item_id => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        ]);

        return redirect('/purchase/' . $item_id);
    }
}