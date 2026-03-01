@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
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
<div class="sell-page">
    <div>
        <h2>商品の出品</h2>
    </div>
    <form class="sell-form" action="/sell" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="sell-form__group">
            <div class="sell-form__label">
                <h3>商品画像</h3>
            </div>
            <div class="sell-form__group-content">
                <div class="item-image">
                    <img class="item-image__img" src="{{ $item->image_path ? Storage::url($item->image_path) : asset('img/noimage.png') }}" alt="商品画像">
                    <input id="image" class="item-image__input" type="file" name="image" accept="image/jpeg,image/png">
                    <label class="item-image__button" for="image">
                        画像を選択する
                    </label>
                </div>
                <div class="form__error">
                    @error('image')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="sell-form__group">
            <div class="sell-form__title">
                <h3>商品の詳細</h3>
            </div>
            <div class="sell-form__categories">
                <span class="sell-form__label">カテゴリー</span>
                @foreach ($categories as $category)
                    <label class="sell-form__category" for="{{ $category['id'] }}">
                        <input class="sell-form__category-input" type="checkbox" name="categories[]" value="{{ $category['id'] }}" id="{{ $category['id'] }}">
                        <span class="sell-form__category-label">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
            <div class="form__error">
                @error('categories')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="sell-form__group">
            <div class="sell-form__title">
                <label class="sell-form__label" for="condition">商品の状態</label>
            </div>
            <div class="sell-form__group-content">
                <select class="sell-form__select" name="condition" value="{{ old('condition') }}" id="condition">
                    <option value="">選択してください</option>
                    <option value="1">良好</option>
                    <option value="2">目立った傷や汚れなし</option>
                    <option value="3">やや傷や汚れあり</option>
                    <option value="4">状態が悪い</option>
                </select>
            </div>
            <div class="form__error">
                @error('condition')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="sell-form__group">
            <div class="sell-form__title">
                <h3>商品名と説明</h3>
            </div>
            <div class="sell-form__group-content">
                <label class="sell-form__label" for="name">商品名</label>
                <input class="sell-form__input" type="text" name="name" id="name" value="{{ old('name') }}">
            </div>
            <div class="form__error">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="sell-form__group">
            <div class="sell-form__group-content">
                <label class="sell-form__label" for="brand_name">ブランド名</label>
                <input class="sell-form__input" type="text" name="brand_name" id="brand_name" value="{{ old('brand_name') }}">
            </div>
            <div class="form__error">
                @error('brand_name')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="sell-form__group">
            <div class="sell-form__group-content">
                <label class="sell-form__label" for="description">商品の説明</label>
                <textarea class="sell-form__textarea" name="description" id="description">{{ old('description') }}</textarea>
            </div>
            <div class="form__error">
                @error('description')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="sell-form__group">
            <div class="sell-form__group-content">
                <label class="sell-form__label" for="price">販売価格</label>
                <div class="price-field">
                    <span class="price-field__prefix">¥</span>
                    <input class="sell-form__input" type="text" name="price" inputmode="numeric" id="price" value="{{ old('price') }}">
                </div>
            </div>
            <div class="form__error">
                @error('price')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <button class="sell-form__submit" type="submit">出品する</button>
    </form>
</div>
@endsection