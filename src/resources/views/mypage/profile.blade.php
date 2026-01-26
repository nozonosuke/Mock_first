@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
<div class="profile-form__content">
    <div class="profile-form__heading">
        <h1>プロフィール設定</h1>
    </div>

    

    <form action="/mypage/profile" class="form" method="post" enctype="multipart/form-data">
        @csrf
        
        {{-- プロフィール画像 --}}
        <div class="profile-image">
            <div class="profile-image__preview">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
                @else
                    <div id="preview-image" class="profile-image__dummy"></div>
                @endif
            </div>

            <label class="profile-image__button">
                画像を選択する
                <input type="file" name="profile_image" id="profile-image-input" hidden>
            </label>

            @error('profile_image')
                <div class="form__error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <label>ユーザー名</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" />
                    <div class="form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>

                <label>郵便番号</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', optional($user->address)->postal_code) }}" />
                    <div class="form__error">
                        @error('postal_code')
                        {{ $message }}
                        @enderror
                    </div>
                
                <label>住所</label>
                <input type="text" name="address" value="{{ old('address', optional($user->address)->address) }}" />
                    <div class="form__error">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>

                <label>建物名</label>
                <input type="text" name="building_name" value="{{ old('building_name', optional($user->address)->building_name) }}" />
                    <div class="form__error">
                        @error('building_name')
                        {{ $message }}
                        @enderror
                    </div>
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-login" type="submit">更新する</button>
        </div>
    </form>
</div>

@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('profile-image-input');
    const preview = document.getElementById('preview-image');

    if (!input || !preview) return;

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        // img要素に変換
        let img;
        if (preview.tagName !== 'IMG') {
            img = document.createElement('img');
            img.id = 'preview-image';
            img.style.width = '120px';
            img.style.height = '120px';
            img.style.borderRadius = '50%';
            img.style.objectFit = 'cover';
            preview.replaceWith(img);
        } else {
            img = preview;
        }

        img.src = URL.createObjectURL(file);
    });
});
</script>
