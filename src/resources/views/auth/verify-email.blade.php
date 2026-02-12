@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection


@section('content')
<div class="verify">
    <div class="verify__inner">

        <p class="verify__text">
            登録していただいたメールアドレスに認証メールを送信しました。<br>
            メール認証を完了してください。
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="verify__button">
                認証はこちらから
            </button>
        </form>

        @if (session('status') === 'verification-link-sent')
            <p class="verify__message">
                認証メールを再送しました。
            </p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="verify__resend">
                認証メールを再送する
            </button>
        </form>

    </div>
</div>
@endsection
