<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title inertia>{{ config("app.name", "TheMovieDB") }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
        <link href="{{ asset('assets/fontawesome-pro/css/all.min.css') }}" rel="stylesheet" />

        <!--Icons-->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-touch-icon.png') }}" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicons/favicon-32x32.png') }}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicons/favicon-16x16.png') }}" />
        <link rel="mask-icon" href="{{ asset('img/favicons/safari-pinned-tab.svg') }}" color="#5bbad5" />
        <link rel="shortcut icon" href="{{ asset('img/favicons/favicon.ico') }}" />
        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="msapplication-config" content="{{ asset('img/favicons/browserconfig.xml') }}" />
        <meta name="theme-color" content="#ffffff" />

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
