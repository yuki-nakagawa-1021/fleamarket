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
        <img class="item-card__img" src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
    </div>
    <div class="item-detail__inner">
        <div class="item-detail__header">
            <div class="item-detail__title">
                <h2 class="item-detail__name">{{ $item['name'] }}</h2>
                <p class="item-detail__brand">{{ $item['brand_name'] }}</p>
            </div>
            <div class="item-detail__buy">
                <p class="item-detail__price">
                    <span class="">¥</span>
                    {{ number_format($item['price']) }}
                    <span class="item-detail__price-tax">（税込）</span>
                </p>
            </div>
            <div class="item-meta">
                <div>
                    @if($item->is_liked_by_auth_user())
                        <a class="item-meta__like" href="/item/unlike/{{ $item['id'] }}">
                            <img class="item-meta__icon" src="{{ asset('img/ハートロゴ_ピンク.png') }}" alt="いいね済み">
                            <span class="item-meta__count">{{ $item['likes']->count() }}</span>
                        </a>
                    @else
                        <a class="item-meta__like" href="/item/like/{{ $item->id }}">
                            <img class="item-meta__icon" src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="いいね">
                            <span class="item-meta__count">{{ $item['likes']->count() }}</span>
                        </a>
                    @endif
                </div>
                <div class="item-meta__comment">
                        <img class="item-meta__icon" src="{{ asset('img/ふきだしロゴ.png') }}" alt="コメント">
                        <span class="item-meta__count">{{ $item['comments_count'] }}</span>
                </div>
            </div>
            <div class="item-detail__purchase">
                <a class="item-detail__purchase-button" href="/purchase/{{ $item['id'] }}">
                    購入手続きへ
                </a>
            </div>
        </div>
        <div class="item-detail__description">
            <h3 class="item-detail__heading">商品説明</h3>
            <div class="item-detail__body">
                <p class="item-detail__text">{{ $item['description'] }}</p>
            </div>
        </div>
        <div class="item-detail__info">
            <h2 class="item-detail__heading">商品の情報</h2>
            <div class="item-info">
                <div class="item-info__row">
                    <span class="item-info__label">カテゴリー</span>
                    <span class="item-info__value--category">{{ $item['categories']->first()['name'] ?? '' }}</span>
                </div>
                <div class="item-info__row">
                    <span class="item-info__label">商品の状態</span>
                    <span class="item-info__value--condition">
                        @if ($item['condition'] == 1)
                            良好
                        @elseif ($item['condition'] == 2)
                            目立った傷や汚れなし
                        @elseif ($item['condition'] == 3)
                            やや傷や汚れあり
                        @else
                            状態が悪い
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="item-detail__comments">
            <h2 class="item-detail__heading">コメント （{{ $item->comments_count }}）</h2>
            <div class="item-comments">
                <div class="item-comments__list">
                    @foreach ($item->comments as $comment)
                        <div class="item-comments__item">
                            <div class="item-comments__avatar">
                                @if (!empty($comment->user->profile_image_path))
                                    <img class="item-comments__avatar-img" src="{{ Storage::url($comment->user->profile_image_path) }}" alt="ユーザーアイコン">
                                @else
                                    <div class="item-comments__avatar-placeholder"></div>
                                @endif
                            </div>
                            <div class="item-comments__content">
                                <p class="item-comments__text">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="item-comments__form-area">
                    <h3 class="item-comments__subheading">商品へのコメント</h3>
                    <form class="item-comments__form" action="/item/comments/{{ $item['id'] }}" method="POST">
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
@endsection