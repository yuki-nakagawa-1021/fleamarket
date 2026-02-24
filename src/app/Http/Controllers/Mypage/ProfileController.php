<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    public function update(UpdateProfileImageRequest $request)
    {
        $user = Auth::user();

        $path = $request->file('profile_image')->store('profile_images', 'public');

        $user->profile_image_path = $path;
        $user->save();

        return redirect('/mypage/profile');
    }
}