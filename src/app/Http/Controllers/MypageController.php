<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;


class MypageController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 'sell');
        $user = auth::user();

        $sellingItems = Item::where('user_id', $user->id)->get();
        $purchasedOrders = Order::with('item')->where('buyer_id', $user->id)->get();

        return view('mypage.index', compact('user', 'sellingItems', 'purchasedOrders', 'page'));
    }
}