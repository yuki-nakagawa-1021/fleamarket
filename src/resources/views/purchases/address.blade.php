@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchases/address.css') }}">
@endsection

@section('content')
<div class="purchase-address-page">
    <div class="purchase-address-page__inner">
        <div class="purchase-address-page__header">
            <h2 class="purchase-address-page__heading">住所の変更</h2>
        </div>
        <form class="purchase-address-form" action="/purchase/address/{{ $item['id'] }}" method="POST">
            @csrf
            <div class="purchase-address-form__group">
                <label class="purchase-address-form__label" for="postal_code">郵便番号</label>
                <div class="purchase-address-form__control">
                    <input class="purchase-address-form__input" id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}">
                    <p class="purchase-address-form__error">
                        @error('postal_code')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
            <div class="purchase-address-form__group">
                <label class="purchase-address-form__label" for="address">住所</label>
                <div class="purchase-address-form__control">
                    <input class="purchase-address-form__input" id="address" type="text" name="address" value="{{ old('address') }}">
                    <p class="purchase-address-form__error">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
            <div class="purchase-address-form__group">
                <label class="purchase-address-form__label" for="building">建物名</label>
                <div class="purchase-address-form__control">
                    <input class="purchase-address-form__input" id="building" type="text" name="building" value="{{ old('building') }}">
                    <p class="purchase-address-form__error">
                        @error('building')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
            <div class="purchase-address-form__action">
                <button class="purchase-address-form__submit" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection