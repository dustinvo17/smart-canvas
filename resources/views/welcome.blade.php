
    @extends('layout.layout')
    @section('title')
        Login
    @endsection
    @section('content')
    <div class="welcome-page">
        <form class="login-form">
        <div class="login-form-logo">
            <img src="{{asset('logo.png')}}" alt="Smart Canvas Logo">
        </div>
        <p>Log in to save your progress, increase your productivity.</p>
        <div class="login-form-button">
            <a href="/auth/google"><img src="{{asset('google.svg')}}">LOGIN WITH GOOGLE</a>
            <a href="/auth/github"><img src="{{asset('github.svg')}}">LOGIN WITH GITHUB</a>

        </div>

        </form>

    </div>
    @endsection