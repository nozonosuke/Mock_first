@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
<div class="header__center">
    <form class="header__search">
        <input type="text" name="keyword" placeholder="なにを探してますか？">
    </form>
</div>

<div class="header__right">
    <form action="/logout" method="post" style="display: inline;">
        @csrf
        <button class="header__nav-link header__nav-link--button">ログアウト</button>
    </form>
    <a href="/mypage" class="header__nav-link">マイページ</a>
    <a href="/sell" class="header__nav-button">出品</a>
</div>
@endsection

@section('content')
<div class="items">
    <div class="items__tabs">
        <span class="tab tab--active">おすすめ</span>
        <span class="tab">マイリスト</span>
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
                </div>

                <p class="item-card__name">{{ $item->name }}</p>
            </a>
        @endforeach
    </div>
    
</div>

@endsection