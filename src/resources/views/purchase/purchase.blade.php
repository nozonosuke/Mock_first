@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
@php
    $user = auth()->user();
@endphp

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
            <select name="payment_method" class="purchase-payment__select">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ支払い</option>
                <option value="credit">カード支払い</option>
            </select>
        </div>

        {{-- 配送先 --}}
        <div class="purchase-address">
            <h3>
                配送先
                <a href="{{ route('purchase.address.edit', $item) }}">変更する</a>
            </h3>

            @if ($address)
                <p>
                    〒 {{ $address['postal_code'] ?? $address->postal_code }}<br>
                    {{ $address['address'] ?? $address->address }}<br>
                    {{ $address['building_name'] ?? $address->building_name }}
                </p>
            @endif
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

        <form action="{{ route('purchase.store', $item) }}" method="post">
            @csrf
            <button class="purchase-submit">購入する</button>
        </form>
    </div>

</div>

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

