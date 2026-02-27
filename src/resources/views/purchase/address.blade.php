@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address-container">

    <h1 class="address-title">住所の変更</h1>

    <form class="address-form" method="post" action="{{ route('purchase.address.update', $item) }}">
        @csrf

        {{-- 郵便番号 --}}
        <div class="address-form__group">
            <label for="postal_code">郵便番号</label>
            <input
                type="text"
                id="postal_code"
                name="postal_code"
                value="{{ old('postal_code', $address->postal_code ?? '') }}"
            >
            @error('postal_code')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 住所 --}}
        <div class="address-form__group">
            <label for="address">住所</label>
            <input
                type="text"
                id="address"
                name="address"
                value="{{ old('address', $address->address ?? '') }}"
            >
            @error('address')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 建物名 --}}
        <div class="address-form__group">
            <label for="building_name">建物名</label>
            <input
                type="text"
                id="building_name"
                name="building_name"
                value="{{ old('building_name', $address->building_name ?? '') }}"
            >
        </div>

        <button type="submit" class="address-submit">
            更新する
        </button>
    </form>

</div>
@endsection