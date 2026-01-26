@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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
<div class="mypage">

    {{-- プロフィール上部 --}}
    <div class="mypage__profile">
        <div class="mypage__icon">
            @if ($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
            @else
                <div class="mypage__icon--dummy"></div>
            @endif
        </div>

        <div class="mypage__name">
            {{ $user->name }}
        </div>

        <a href="/mypage/profile" class="mypage__edit">
            プロフィールを編集
        </a>
    </div>

    {{-- タブ --}}
    <div class="mypage__tabs">
        <a href="{{ url('/mypage?page=sell') }}" class="tab {{ $page === 'sell' ? 'tab--active' : '' }}" >出品した商品</a>
        <a href="{{ url('/mypage?page=buy') }}" class="tab {{ $page === 'buy' ? 'tab--active' : '' }}" >購入した商品</a>
    </div>

    {{-- 出品商品一覧 --}}
    @if ($page === 'sell')
    <div class="items__list">
        @forelse ($sellItems as $item)
            <div class="item-card">
                <div class="item-card__image">
                    @if ($item->image_url)
                        <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                    @else
                        <div class="item-card__image--dummy"></div>
                    @endif
                </div>

                <p class="item-card__name">{{ $item->name }}</p>
            </div>
        @empty
            <p class="items__empty">出品した商品はありません</p>
        @endforelse
    </div>
    @endif


    {{-- 購入した商品一覧 --}}
    @if ($page === 'buy')
    <div class="items__list">
        @forelse ($buyItems as $purchase)
            <div class="item-card">
                <div class="item-card__image">
                    @if ($purchase->item->image_url)
                        <img src="{{ asset('storage/' . $purchase->item->image_url) }}"
                            alt="{{ $purchase->item->name }}">
                    @else
                        <div class="item-card__image--dummy"></div>
                    @endif
                </div>

                <p class="item-card__name">{{ $purchase->item->name }}</p>

                <p class="item-card__price">
                    ¥{{ number_format($purchase->price_at_purchase) }}
                </p>
            </div>
        @empty
            <p class="items__empty">購入した商品はありません</p>
        @endforelse
    </div>
    @endif



</div>
@endsection
