@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
<div class="purchase-page">
    <form class="purchase-form" action="/purchase/{{ $item['id'] }}" method="POST">
        @csrf

        <div class="purchase-page__inner">
            <div class="purchase-content">
                <div class="purchase-product">
                    <div class="purchase-product__image">
                        <img class="purchase-product__img" src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                    </div>
                    <div class="purchase-product__info">
                        <h2 class="purchase-product__name">{{ $item['name'] }}</h2>
                        <p class="purchase-product__price">
                            <span>¥</span>
                            {{ number_format($item['price']) }}
                        </p>
                    </div>
                </div>

                <div class="purchase-section">
                    <h3 class="purchase-section__heading">支払い方法</h3>
                    <div class="purchase-section__body">
                        <select class="purchase-section__select" name="payment_method">
                            <option value="">選択してください</option>
                            <option value="1">コンビニ払い</option>
                            <option value="2">カード支払い</option>
                        </select>
                    </div>
                </div>

                <div class="purchase-section">
                    <div class="purchase-section__header">
                        <h3 class="purchase-section__heading">配送先</h3>
                        <a class="purchase-section__link" href="/purchase/address/{{ $item['id'] }}">変更する</a>
                    </div>
                    <div class="purchase-section__body">
                        <p class="purchase-section__text">{{ $user['postal_code'] }}</p>
                        <p class="purchase-section__text">{{ $user['address'] }}</p>
                        @if (!empty($user['building']))
                            <p class="purchase-section__text">{{ $user['building'] }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="purchase-summary">
                <div class="purchase-summary__box">
                    <div class="purchase-summary__row">
                        <span class="purchase-summary__label">商品代金</span>
                        <span class="purchase-summary__value">¥{{ number_format($item['price']) }}</span>
                    </div>
                    <div class="purchase-summary__row">
                        <span class="purchase-summary__label">支払い方法</span>
                        <span class="purchase-summary__value">選択してください</span>
                    </div>
                </div>

                <button class="purchase-summary__button" type="submit">購入する</button>
            </div>
        </div>
    </form>
</div>
@endsection