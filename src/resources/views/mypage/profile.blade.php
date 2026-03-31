@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/profile.css') }}" >
@endsection

@section('content')
<div class="mypage-profile__content">
    <div class="mypage-profile__heading">
        <h2>プロフィール設定</h2>
    </div>
    <form class="form" action="/mypage/profile" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form__group">
            <div class="form__group-content">
                <div class="profile-image">
                    <img id="profileImagePreview" class="profile-image__img" src="{{ $user->profile_image_path ? Storage::url($user->profile_image_path) : asset('img/default-user.png') }}" alt="プロフィール画像">
                    <input id="profile_image" class="profile-image__input" type="file" name="profile_image" accept="image/jpeg,image/png">
                    <label class="profile-image__button" for="profile_image">画像を選択する</label>
                </div>
                <div class="form__error">
                    @error('profile_image')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <label for="user_name" class="form__label--item">ユーザー名</label>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input id="user_name" type="text" name="user_name" value="{{ old('user_name', $user['user_name']) }}"/>
                </div>
                <div class="form__error">
                    @error('user_name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <label for="postal_code" class="form__label--item">郵便番号</label>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code', $user['postal_code']) }}"/>
                </div>
                <div class="form__error">
                    @error('postal_code')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <label for="address" class="form__label--item">住所</label>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input id="address" type="text" name="address" value="{{ old('address' ,$user['address']) }}"/>
                </div>
                <div class="form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <label for="building" class="form__label--item">建物名</label>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input id="building" type="text" name="building" value="{{ old('building', $user['building']) }}"/>
                </div>
                <div class="form__error">
                    @error('building')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>

<script>
const profileImageInput=document.getElementById('profile_image');
const profileImagePreview=document.getElementById('profileImagePreview');

profileImageInput.addEventListener('change',function(event){
    const file=event.target.files[0];

    if(!file){
        return;
    }

    const reader=new FileReader();

    reader.onload=function(e){
        profileImagePreview.src=e.target.result;
    };

    reader.readAsDataURL(file);
});
</script>
@endsection