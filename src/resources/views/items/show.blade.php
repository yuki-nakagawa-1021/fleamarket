@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
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
        <img class="item-card__img" src="{{ $item['image_path'] }}" alt="{{ $item->name }}">
    </div>
    <div class="item-detail__inner">
        <div class="item-detail__header">
            <div class="item-detail__title">
                <h2 class="item-detail__name">{{-- $item['name'] --}}</h2>
                <p class="item-detail__brand">{{-- $item['brand_name'] --}}</p>
            </div>
            <div class="item-detail__buy">
                <p class="item-detail__price">
                    ¥{{-- number_format($item['price']) --}}
                    <span class="item-detail__price-tax">（税込）</span>
                </p>
                <div class="item-detail__purchase">
                    <a class="item-detail__purchase-button" href="/purchase/{{ $item['id'] }}">
                        購入手続きへ
                    </a>
                </div>
            </div>
        </div>
        <div class="item-detail__description">
            <h3 class="item-detail__heading">商品説明</h3>
            <div class="item-detail__body">
                <p class="item-detail__text">

                </p>
            </div>
        </div>
        <div class="item-detail__info">
            <h3 class="item-detail__heading">商品の情報</h3>
            <div class="item-detail__body">
                <div class="item-info">
                    <div class="item-info__row">
                        <span class="item-info__label">ブランド</span>
                    </div>
                    {{-- 必要なら後で追加：状態、カテゴリなど --}}
                    {{-- <div class="item-info__row">...</div> --}}
                </div>
            </div>
        </div>
            <div class="item-detail__comments">
                <h2 class="item-detail__heading">コメント</h2>
                <div class="item-comments">
                    <div class="item-comments__form-area">
                        <h3 class="item-comments__subheading">商品へのコメント</h3>
                        <form class="item-comments__form" action="/item/{{ $item['id'] }}/comments" method="POST">
                            @csrf
                            <div class="item-comments__field">
                                <textarea class="item-comments__textarea" name="comment" rows="5" placeholder="コメントを入力してください">{{ old('comment') }}</textarea>
                            </div>
                            <div class="item-comments__actions">
                                <button class="item-comments__submit" type="submit">
                                    コメントを送信する
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection