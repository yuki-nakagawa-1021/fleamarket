<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Order;



class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $sellingItems = Item::where('user_id', $user->id)->get();
        $purchasedOrders = Order::with('item')->where('buyer_id', $user->id)->get();

        return view('mypage.index', compact('user', 'sellingItems', 'purchasedOrders'));
    }
}
