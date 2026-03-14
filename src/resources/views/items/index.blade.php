@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
<div class="item-page">
    <div class="item-tabs">
        <a class="item-tabs__heading {{ $tab === 'recommend' ? 'is-active' : '' }}" href="/">おすすめ</a>
        <a class="item-tabs__heading {{ $tab === 'mylist' ? 'is-active' : '' }}" href="/?tab=mylist">マイリスト</a>
    </div>
    <div class="item-list">
    @if ($tab === 'mylist')
        @foreach ($mylistItems as $item)
            <div class="item-card">
                <a href="/item/{{ $item['id'] }}">
                    <div class="item-card__image-wrap">
                        <img class="item-card__img" src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                        @if ($item->order)
                            <div class="item-card__sold">SOLD</div>
                        @endif
                    </div>
                </a>
                <p class="item-card__name">{{ $item['name'] }}</p>
            </div>
        @endforeach
    @else
        @foreach ($items as $item)
            <div class="item-card">
                <a href="/item/{{ $item['id'] }}">
                    <div class="item-card__image-wrap">
                        <img class="item-card__img" src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                        @if ($item->order)
                            <div class="item-card__sold">SOLD</div>
                        @endif
                    </div>
                </a>
                <p class="item-card__name">{{ $item['name'] }}</p>
            </div>
        @endforeach
    @endif
</div>
</div>
@endsection
