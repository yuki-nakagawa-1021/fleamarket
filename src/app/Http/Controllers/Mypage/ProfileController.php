<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('mypage.index');
    }

    public function edit()
    {
        return view('mypage.profile');
    }

}
