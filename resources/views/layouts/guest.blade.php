<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset("assets") }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <meta name="title" content="Code Ecstasy Course Management System">
        <meta name="description" content="Code Ecstasy Course Management System is a course management system where you one can handle payments attendance course exams etc. Grab your copy now!">
        <meta name="author" content="https://codecstasy.com">
        <link rel="shortcut icon" href="{{ asset("images/favicon/favicon.png") }}" type="image/x-icon">

        <title>{{ env("APP_NAME","Course Management System") }} - Code Ecstasy</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="bg-light font-sans antialiased">
        {{ $slot }}
    </body>
</html>