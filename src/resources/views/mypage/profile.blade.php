@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-form__content">
    <div class="profile-form__heading">
        <h1>プロフィール設定</h1>
    </div>

    <form action="/mypage" class="form" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <label>ユーザー名</label>
                <input type="text" name="name" value="{{ old('name') }}" />
                    <div class="form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>

                <label>郵便番号</label>
                <input type="text" name="address" value="{{ old('address') }}" />
                    <div class="form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                
                <label>住所</label>
                <input type="password" name="password" value="{{ old('password') }}" />
                    <div class="form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>

                <label>建物名</label>
                <input type="password" name="password" value="{{ old('password') }}" />
                    <div class="form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-login" type="submit">ログインする</button>
        </div>
    </form>
</div>

@endsection