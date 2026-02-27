@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
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
<div class="sell-container">

    <h1 class="sell-title">商品の出品</h1>

    <form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="sell-section">
            <h2 class="sell-section__title">商品画像</h2>

            <div class="image-upload">

                {{-- プレビュー表示 --}}
                <img class="image-preview">

                <label class="image-upload__button">
                    画像を選択する
                    <input
                        type="file"
                        name="image"
                        accept="image/png,image/jpeg"
                        onchange="previewImage(this)"
                    >
                </label>
            </div>

            @error('image')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品の詳細 --}}
        <div class="sell-section">
            <h2 class="sell-section__title">商品の詳細</h2>

            <div class="form-group">
                <label>カテゴリー</label>

                <div class="category-list">
                    @foreach ($categories as $category)
                        <input
                            type="checkbox"
                            id="category_{{ $category->id }}"
                            name="categories[]"
                            value="{{ $category->id }}"
                            class="category-item"
                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                        >
                        <label for="category_{{ $category->id }}" class="category-label">
                            {{ $category->content }}
                        </label>
                    @endforeach
                </div>

                @error('categories')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            {{-- 商品の状態 --}}
            <div class="form-group">
                <label for="condition">商品の状態</label>
                <select name="condition" id="condition" class="select-box">
                    <option value="">選択してください</option>
                    <option value="良好">良好</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="傷や汚れあり">傷や汚れあり</option>
                </select>

                @error('condition')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 商品名と説明 --}}
        <div class="sell-section">
            <h2 class="sell-section__title">商品名と説明</h2>

            <div class="form-group">
                <label for="name">商品名</label>
                <input id="name" type="text" name="name" class="form-input" value="{{ old('name') }}">

                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="brand_name">ブランド名</label>
                <input id="brand_name" type="text" name="brand_name" class="form-input" value="{{ old('brand_name') }}">
            </div>

            <div class="form-group">
                <label for="description">商品の説明</label>
                <textarea id="description" name="description" class="form-textarea">{{ old('description') }}</textarea>

                @error('description')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">販売価格</label>
                <div class="price-input">
                    <span>¥</span>
                    <input id="price" type="number" name="price" class="form-input" value="{{ old('price') }}">
                </div>

                @error('price')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 出品ボタン --}}
        <button type="submit" class="submit-button">
            出品する
        </button>

    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.querySelector('.image-preview');
    const button = document.querySelector('.image-upload__button');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            button.style.display = 'none';
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
