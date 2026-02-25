@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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
        <li class="header-nav__item">
            <form class="header-nav__form" action="/logout" method="POST">
                @csrf
                <button class="header-nav__button">ログアウト</button>
            </form>
        </li>
        <li class="header-nav__item">
            <a class="header-nav__link" href="/mypage">マイページ</a>
        </li>
        <li class="header-nav__item">
            <a class="header-nav__sell" href="/sell">出品</a>
        </li>
    </ul>
</nav>
@endsection

@section('content')
<div class="mypage__content">
    <div class="mypage__profile">
        @if ($user->profile_image_path)
            <img class="mypage-image__img" src="{{ Storage::url($user->profile_image_path) }}" alt="プロフィール画像">
        @else
            <div class="mypage-image__placeholder"></div>
        @endif
        <div class="mypage__name">
            <h2 class="mypage__user-name">
                {{ $user['user_name'] }}
            </h2>
        </div>
        <div class="mypage__action">
            <a href="/mypage/profile" class="mypage-profile__button">プロフィールを編集</a>
        </div>
    </div>
    <div class="mypage-products-tabs">
        <span class="mypage-products-tabs__heading">出品した商品</span>
        <span class="mypage-products-tabs__heading">購入した商品</span>
    </div>
    <div class="mypage-products">
        <div class="mypage-products__list">
            @foreach ($sellingItems as $item)
                <div class="mypage-products__card">
                    <img class="mypage-products__img" src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}">
                    <p class="mypage-products__name">{{ $item->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mypage-products">
        <div class="mypage-products__list">
            @foreach ($purchasedOrders as $order)
                @if ($order->item)
                    <div class="mypage-products__card">
                        <img class="mypage-products__img" src="{{ Storage::url($order->item->image_path) }}" alt="{{ $order->item->name }}">
                        <p class="mypage-products__name">{{ $order->item->name }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection