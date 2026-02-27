@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('header')
<div class="header__center">
    <form class="header__search">
        <input type="text" placeholder="なにを探してますか？">
    </form>
</div>

<div class="header__right">
    <form action="/logout" method="post">
        @csrf
        <button class="header__nav-link header__nav-link--button">
            ログアウト
        </button>
    </form>
    <a href="/mypage" class="header__nav-link">マイページ</a>
    <a href="/sell" class="header__nav-button">出品</a>
</div>
@endsection

@section('content')
@php
    $user = auth()->user();
@endphp

<form action="{{ route('purchase.store', $item) }}" method="post" novalidate>
    @csrf
<div class="purchase-container">

    {{-- 左カラム --}}
    <div class="purchase-left">

        {{-- 商品情報 --}}
        <div class="purchase-item">
            <div class="purchase-item__image">
                @if ($item->image_url)
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                @else
                    <div class="image--dummy">商品画像</div>
                @endif
            </div>

            <div class="purchase-item__info">
                <h2>{{ $item->name }}</h2>
                <p class="price">¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        {{-- 支払い方法 --}}
        <div class="purchase-payment">
            <h3>支払い方法</h3>

            <div class="purchase-indent">
                <select 
                    name="payment_method" 
                    class="purchase-payment__select @error('payment_method') error-input @enderror"
                >
                    <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>
                        選択してください
                    </option>

                    <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>
                        コンビニ支払い
                    </option>

                    <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>
                        カード支払い
                    </option>
                </select>

                @error('payment_method')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 配送先 --}}
        <div class="purchase-address">
            <h3>
                配送先
                <a href="{{ route('purchase.address.edit', $item) }}">変更する</a>
            </h3>

            @if ($address)
                <div class="purchase-indent">
                    <p>
                        〒 {{ $address['postal_code'] ?? $address->postal_code }}<br>
                        {{ $address['address'] ?? $address->address }}<br>
                        {{ $address['building_name'] ?? $address->building_name }}
                    </p>
                </div>

                <input type="hidden" name="shipping_address" value="{{ $address->id ?? 1 }}">
            @endif

            @error('shipping_address')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- 右カラム --}}
    <div class="purchase-right">
        <div class="purchase-summary">

            <div class="summary-row">
                <span>商品代金</span>
                <span>¥{{ number_format($item->price) }}</span>
            </div>

            <div class="summary-row">
                <span>支払い方法</span>
                <span id="summary-payment">未選択</span>
            </div>
        </div>

        <button class="purchase-submit">購入する</button>
    </div>

</div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.querySelector('.purchase-payment__select');
    const summary = document.getElementById('summary-payment');

    if (!select || !summary) return;

    select.addEventListener('change', function () {
        summary.innerText = this.options[this.selectedIndex].text;
    });
});
</script>


@endsection

