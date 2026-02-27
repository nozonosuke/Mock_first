@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-form__content">
    <div class="login-form__heading">
        <h1>ログイン</h1>
    </div>

    <form action="/login" class="form" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" />
                    <div class="form__error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" />
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

        <div class="form__register">
            <a href="/register">会員登録はこちら</a>
        </div>
    </form>
</div>

@endsection