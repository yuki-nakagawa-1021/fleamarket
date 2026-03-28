@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('header')
<form class="search-form" action="/search" method="GET">
    @csrf
    <div class="search-form__item">
        <input class="search-form__item-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ old('keyword') }}">
    </div>
</form>
<nav>
    <ul class="header-nav">
        @if (Auth::check())
        <li class="header-nav__item">
            <form class="header-nav__form" action="/logout" method="POST">
                @csrf
                <button class="header-nav__button" type="submit">ログアウト</button>
            </form>
        </li>
        <li class="header-nav__item">
            <a class="header-nav__link" href="/mypage">マイページ</a>
        </li>
        <li class="header-nav__item">
            <a class="header-nav__sell" href="/sell">出品</a>
        </li>
        @else
            <li class="header-nav__item">
                <a class="header-nav__link" href="/login">ログイン</a>
            </li>
        @endif
    </ul>
</nav>
@endsection

@section('content')
<div class="purchase-address-page">
    <div class="purchase-address-page__inner">
        <div class="purchase-address-page__header">
            <h2 class="purchase-address-page__heading">住所の変更</h2>
        </div>
        <form class="purchase-address-form" action="/purchase/address/{{ $item['id'] }}" method="POST">
            @csrf
            <div class="purchase-address-form__group">
                <label class="purchase-address-form__label" for="postal_code">郵便番号</label>
                <div class="purchase-address-form__control">
                    <input class="purchase-address-form__input" id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}">
                    <p class="purchase-address-form__error">
                        @error('postal_code')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
            <div class="purchase-address-form__group">
                <label class="purchase-address-form__label" for="address">住所</label>
                <div class="purchase-address-form__control">
                    <input class="purchase-address-form__input" id="address" type="text" name="address" value="{{ old('address') }}">
                    <p class="purchase-address-form__error">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
            <div class="purchase-address-form__group">
                <label class="purchase-address-form__label" for="building">建物名</label>
                <div class="purchase-address-form__control">
                    <input class="purchase-address-form__input" id="building" type="text" name="building" value="{{ old('building') }}">
                    <p class="purchase-address-form__error">
                        @error('building')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
            <div class="purchase-address-form__action">
                <button class="purchase-address-form__submit" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection