<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Stripe\StripeClient;

class PurchaseController extends Controller
{
    public function create($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        $shippingAddress = session('purchase_address.' . $item_id, [
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        return view('purchases.create', compact('item', 'user', 'shippingAddress'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::with('order')->findOrFail($item_id);
        $user = auth()->user();

        $shippingAddress = session('purchase_address.' . $item_id, [
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $stripe = new StripeClient(config('services.stripe.secret'));

        $checkout = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'payment_method_types' => [$request->payment_method],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => (int) $item->price,
                    'product_data' => [
                        'name' => $item->name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'customer_email' => $user->email,
            'client_reference_id' => (string) $item->id,
            'metadata' => [
                'item_id' => (string) $item->id,
                'buyer_id' => (string) $user->id,
                'payment_method' => $request->payment_method,
                'postal_code' => $shippingAddress['postal_code'],
                'address' => $shippingAddress['address'],
                'building' => $shippingAddress['building'] ?? '',
            ],

            'success_url' => url('/purchase/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/purchase/' . $item->id),
        ]);

        return redirect($checkout->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect('/');
        }

        $stripe = new StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        if (($session->payment_status ?? null) !== 'paid') {
            return redirect('/');
        }

        $itemId = $session->metadata->item_id ?? null;
        $buyerId = $session->metadata->buyer_id ?? null;

        if (!$itemId || !$buyerId) {
            return redirect('/');
        }

        $item = Item::with('order')->find($itemId);

        if (!$item) {
            return redirect('/');
        }

        if (!$item->order) {
            Order::create([
                'item_id' => $itemId,
                'buyer_id' => $buyerId,
                'payment_method' => $session->metadata->payment_method ?? null,
                'postal_code' => $session->metadata->postal_code ?? null,
                'address' => $session->metadata->address ?? null,
                'building' => $session->metadata->building ?? null,
            ]);
        }

        session()->forget('purchase_address.' . $itemId);

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

    public function updateAddress(AddressRequest $request, $item_id)
    {
        session([
            'purchase_address.' . $item_id => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        ]);

        return redirect('/purchase/' . $item_id);
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();

        if (($payload['type'] ?? null) !== 'checkout.session.completed') {
            return response()->json(['status' => 'ignored'], 200);
        }

        $session = $payload['data']['object'] ?? null;

        if (!$session) {
            return response()->json(['status' => 'no session'], 400);
        }

        $itemId = $session['metadata']['item_id'] ?? null;
        $buyerId = $session['metadata']['buyer_id'] ?? null;

        if (!$itemId || !$buyerId) {
            return response()->json(['status' => 'metadata missing'], 400);
        }

        $item = Item::with('order')->find($itemId);

        if (!$item) {
            return response()->json(['status' => 'item not found'], 404);
        }

        if ($item->order) {
            return response()->json(['status' => 'already ordered'], 200);
        }

        Order::create([
            'item_id' => $itemId,
            'buyer_id' => $buyerId,
            'payment_method' => $session['metadata']['payment_method'] ?? null,
            'postal_code' => $session['metadata']['postal_code'] ?? null,
            'address' => $session['metadata']['address'] ?? null,
            'building' => $session['metadata']['building'] ?? null,
        ]);

        return response()->json(['status' => 'ok'], 200);
    }
}