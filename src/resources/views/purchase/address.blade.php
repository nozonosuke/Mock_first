@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address-container">

    <h1 class="address-title">住所の変更</h1>

    <form class="address-form" method="post">
        @csrf

        {{-- 郵便番号 --}}
        <div class="address-form__group">
            <label for="postal_code">郵便番号</label>
            <input
                type="text"
                id="postal_code"
                name="postal_code"
            >
        </div>

        {{-- 住所 --}}
        <div class="address-form__group">
            <label for="address">住所</label>
            <input
                type="text"
                id="address"
                name="address"
            >
        </div>

        {{-- 建物名 --}}
        <div class="address-form__group">
            <label for="building_name">建物名</label>
            <input
                type="text"
                id="building_name"
                name="building_name"
            >
        </div>

        <button type="submit" class="address-submit">
            更新する
        </button>
    </form>

</div>
@endsection