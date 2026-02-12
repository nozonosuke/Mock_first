@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
<div class="header__center">
    <form class="header__search" action="{{ route('products.index') }}" method="get">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにを探してますか？">
    </form>
</div>

<div class="header__right">
    @auth
        <form action="/logout" method="post" style="display: inline;">
            @csrf
            <button class="header__nav-link header__nav-link--button">ログアウト</button>
        </form>
        <a href="/mypage" class="header__nav-link">マイページ</a>
        <a href="/sell" class="header__nav-button">出品</a>
    @else
        <a href="/login" class="header__nav-link">ログイン</a>
    @endauth
</div>

@endsection

@section('content')
<div class="items">
    <div class="items__tabs">
        <a href="{{ route('products.index', request()->except('tab')) }}"
        class="tab {{ request('tab') !== 'mylist' ? 'tab--active' : '' }}">
            おすすめ
        </a>

        <a href="{{ route('products.index', array_merge(request()->except('tab'), ['tab' => 'mylist'])) }}"
        class="tab {{ request('tab') === 'mylist' ? 'tab--active' : '' }}">
            マイリスト
        </a>
    </div>


    <div class="items__list">
        @foreach ($items as $item)
            <a href="{{ route('item.show', $item->id) }}" class="item-card">
                <div class="item-card__image">
                    @if ($item->image_url)
                        <img src="{{ asset('storage/' . $item->image_url) }}" alt="商品画像 : {{ $item->name }}">
                    @else
                        <div class="item-card__image--dummy"></div>
                    @endif

                    {{-- SOLD表示 --}}
                    @if ($item->purchase->isNotEmpty())
                        <div class="item-card__sold">SOLD</div>
                    @endif
                </div>

                <p class="item-card__name">{{ $item->name }}</p>
            </a>
        @endforeach
    </div>
    
</div>

@endsection