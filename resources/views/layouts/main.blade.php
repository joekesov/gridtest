<?php
if (!isset($pageTitle)) {
    $pageTitle = null;
}
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">

        <title>{{ __('Shkolo:::page_title', ['page_title' => $pageTitle]) }}</title>

        @yield('head')
    </head>

    <body class="">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')

        @yield('javascript')
    </body>
</html>
