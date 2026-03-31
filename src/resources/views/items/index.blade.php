@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('content')
<div class="item-page">
    <div class="item-tabs">
        <a class="item-tabs__heading {{ $tab === 'recommend' ? 'is-active' : '' }}" href="/?tab=recommend&keyword={{ $keyword }}">
            おすすめ
        </a>
        <a class="item-tabs__heading {{ $tab === 'mylist' ? 'is-active' : '' }}" href="/?tab=mylist&keyword={{ $keyword }}">
            マイリスト
        </a>
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
