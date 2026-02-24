<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $form = $request->all();

        if ($request->hasFile('profile_image')) {
            $form['profile_image_path'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        unset($form['_token']);
        unset($form['profile_image']);

        $user->update($form);

        return redirect('/mypage');
    }
}