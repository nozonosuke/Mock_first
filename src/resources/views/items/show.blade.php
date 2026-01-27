@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
<div class="item-detail">

    {{-- 左：商品画像 --}}
    <div class="item-detail__image">
        @if ($item->image_url)
            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
        @else
            <div class="item-detail__image--dummy">商品画像</div>
        @endif
    </div>

    {{-- 右：商品情報 --}}
    <div class="item-detail__info">

        <h1 class="item-detail__name">{{ $item->name }}</h1>
        <p class="item-detail__brand">{{ $item->brand_name ?? 'ブランド名なし' }}</p>

        <p class="item-detail__price">
            ¥{{ number_format($item->price) }}
            <span>(税込)</span>
        </p>

        {{-- いいね・コメント数（仮） --}}
        @php
            $liked = auth()->check()
                ? $item->favoredUsers->contains(auth()->id())
                : false;
        @endphp

        <div class="item-detail__icons">

            {{-- いいね --}}
            @auth
                <form action="{{ route('item.favorite', $item) }}" method="post">
                    @csrf
                    <button type="submit"
                        class="like-button {{ $liked ? 'is-liked' : '' }}">
                        ♥ {{ $item->favorites->count() }}
                    </button>
                </form>
            @else
                <span>♥ {{ $item->favorites->count() }}</span>
            @endauth

            {{-- コメント数 --}}
            <span>💬 {{ $item->comments->count() }}</span>

    </div>


        {{-- 購入ボタン --}}
        @auth
            <a href="{{ route('purchase.purchase', $item) }}"
            class="item-detail__buy">
                購入手続きへ
            </a>
        @else
            <a href="{{ route('login') }}" class="item-detail__buy">
                ログインして購入
            </a>
        @endauth

        {{-- 商品説明 --}}
        <div class="item-detail__section">
            <h2>商品説明</h2>
            <p>{{ $item->description ?? '説明文が入ります' }}</p>
        </div>

        {{-- 商品情報 --}}
        <div class="item-detail__section">
            <h2>商品の情報</h2>

            <dl class="item-detail__meta">
                <dt>カテゴリー</dt>
                <dd>
                    @foreach ($item->categories as $category)
                        <span class="tag">{{ $category->content }}</span>
                    @endforeach
                </dd>

                <dt>商品の状態</dt>
                <dd>{{ $item->condition }}</dd>
            </dl>
        </div>

        {{-- コメント --}}
        <div class="item-detail__section">
            <h2>コメント{{ $item->comments->count() }}</h2>
            
            {{-- コメント一覧 --}}
            @forelse ($item->comments as $comment)
                <div class="comment">
                    <div class="comment__user">
                        {{ $comment->user->name }}
                    </div>
                    <div class="comment__body">
                        {{ $comment->comment }}
                    </div>
                </div>
            @empty
                <p>まだコメントはありません</p>
            @endforelse

            {{-- コメント投稿（※次のステップで実装） --}}
            <form action="{{ route('comment.store', $item->id) }}" method="post">
                @csrf

                <textarea class="comment__textarea" name="comment" placeholder="商品へのコメント">{{ old('comment') }}</textarea>

                @error('comment')
                    <p class="form__error">{{ $message }}</p>
                @enderror

                <button class="comment__submit">
                    コメントを送信する
                </button>
            </form>
            
        </div>

    </div>
</div>
@endsection
