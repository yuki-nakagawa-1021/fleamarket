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
<div class="item-detail">
    <div class="item-card">
        <img class="item-card__img" src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
    </div>
    <div class="item-detail__inner">
        <div class="item-detail__header">
            <div class="item-detail__title">
                <h2 class="item-detail__name">{{ $item['name'] }}</h2>
            </div>
            <div class="item-detail__buy">
                <p class="item-detail__price">
                    <span class="">¥</span>
                    {{ number_format($item['price']) }}
                    <span class="item-detail__price-tax">（税込）</span>
                </p>
            </div>
        </div>
        <div>
            <div>
                <h2>支払い方法</h2>
            </div>
            <form action="/purchase/{{ $item['id'] }}" method="POST">
                @csrf
                <select name="payment_method">
                    <option value="">選択してください</option>
                    <option value="1">コンビニ払い</option>
                    <option value="2">カード支払い</option>
                </select>
                <div>
                    <div>
                        <h2>配送先</h2>
                    </div>
            <div>
                <p>{{ $user['postal_code'] }}</p>
                <p>{{ $user['address'] }}</p>
            </div>
        </div>
    <div>
        <div>
            <div class="item-card">
                <span>商品代金</span>
                <span class="">¥{{ number_format($item['price']) }}</span>
            </div>
            <div>
                <span>支払い方法</span>
                <span></span>
            </div>
        </div>
    </div>
    <div>
        <button type="submit">購入する</button>
    </div>
</form>
@endsection