@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection


@section('content')
<div class="register-form__content">
    <div class="register-form__heading">
        <h1>会員登録</h1>
    </div>

    <form action="" class="form">
        <div class="form__group">
            <div class="form__group-title">
                <label>ユーザー名</label>
                <input type="text" name="name">

                <label>メールアドレス</label>
                <input type="email" name="email">
                
                <label>パスワード</label>
                <input type="password" name="password">

                <label>メールアドレス</label>
                <input type="password" name="password_confirmation">
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-register" type="submit">登録する</button>
        </div>

        <div class="form__login">
            <a href="/">ログインはこちら</a>
        </div>
    </form>
</div>

@endsection