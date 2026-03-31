@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
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
        <a class="mypage-products-tabs__tab {{ $page === 'sell' ? 'is-active' : '' }}" href="/mypage?page=sell">
            出品した商品
        </a>
        <a class="mypage-products-tabs__tab {{ $page === 'buy' ? 'is-active' : '' }}" href="/mypage?page=buy">
            購入した商品
        </a>
    </div>
    <div class="mypage-products">
        <div class="mypage-products__list">
            @if ($page === 'buy')
                @foreach ($purchasedOrders as $order)
                    @if ($order['item'])
                        <div class="mypage-products__card">
                            <img class="mypage-products__img" src="{{ $order['item']['image_url'] }}" alt="{{ $order['item']['name'] }}">
                            <p class="mypage-products__name">{{ $order['item']['name'] }}</p>
                        </div>
                    @endif
                @endforeach
            @else
                @foreach ($sellingItems as $item)
                    <div class="mypage-products__card">
                        <img class="mypage-products__img" src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                        <p class="mypage-products__name">{{ $item['name'] }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection