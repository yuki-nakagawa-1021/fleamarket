@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" >
@endsection

@section('content')
<div class="mypage-profile__content">
    <div class="mypage-profile__heading">
        <h2>プロフィール設定</h2>
    </div>
    <form action="/mypage/profile" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form__group">
            <div class="profile-image">
                <div class="profile-image__preview">
                @if ($user->profile_image_path)
                    <img class="profile-image__img" src="{{ Storage::url($user->profile_image_path) }}" alt="プロフィール画像">
                @else
                    <div class="profile-image__placeholder"></div>
                @endif
                </div>
                <input  id="profile_image" class="profile-image__input" type="file" name="profile_image" accept="image/jpeg,image/png">
                <label class="profile-image__button" for="profile_image">
                    画像を選択する
                </label>
                @error('profile_image')
                    {{ $message }}
                @enderror
            </div>
        </div>
    </form>
    <form class="form" action="/mypage/profile" method="POST">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">ユーザー名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{ old('name') }}"/>
                </div>
                <div class="form__error">

                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">郵便番号</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"/>
                </div>
                <div class="form__error">

                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" value="{{ old('address') }}"/>
                </div>
                <div class="form__error">

                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" value="{{ old('building') }}"/>
                </div>
                <div class="form__error">

                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection