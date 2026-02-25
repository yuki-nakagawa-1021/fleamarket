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
        <span class="item-tabs__heading">おすすめ</span>
        <span class="item-tabs__heading">マイリスト</span>
    </div>
    <div class="item-list">
        @foreach ($items as $item)
        <div class="item-card">
            <img class="item-card__img" src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}">
            <p class="item-card__name">{{ $item->name }}</p>
        </div>
        @if ($item->order)
            <span class="sold-label">SOLD</span>
        @endif
        <div class="item-card">
        </div>
        @endforeach
    </div>
</div>
@endsection
