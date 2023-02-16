<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="{{ env('META_TITLE', 'Code Ecstasy Course Management System') }}">
    <meta name="description"
        content="{{ env('META_DESCRIPTION', "It's") }} is a Course Management System built by Code Ecstasy where you one can handle payments attendance course exams etc. Grab your copy now!">
    <meta name="author" content="https://codecstasy.com">

    <title>{{ config('app.name', 'Code Ecstasy') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased bg-light">
    <x-jet-banner />
    @livewire('navigation-menu')

    <!-- Page Heading -->
    <header class="d-flex py-3 bg-white shadow-sm border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-1"> <a href="{{ route('dashboard') }}"
                        class="btn btn-dark mx-auto">Back</a></div>
                <div class="col-md-11"> {{ $header }}</div>
            </div>


        </div>
    </header>

    <!-- Page Content -->
    <main class="container my-5">
        {{ $slot }}
    </main>

    @stack('modals')

    @livewireScripts

    @stack('scripts')
</body>

</html>
