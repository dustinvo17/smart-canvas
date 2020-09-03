<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Smart Canvas | @yield('title')</title>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link href="/public/css/app.css" rel="stylesheet">
    <link rel="icon" href="/public/logo.png">
    </head>
    <body>
        @yield('content')
    </body>

@if(!Request::is("/") && Auth::check())
<script>
    window.access_token = {!! json_encode($access_token); !!};
</script>
<script type="text/javascript" src="/public/js/app.js'"></script>

@endif
</html>
