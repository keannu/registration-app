<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registration App Dashboard</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <!-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> -->
    </head>
    <body>
        <div id="dashboard">

        </div>
    </body>
    <footer>
        <script type="text/javascript" src="{{ mix('/js/dashboard.js') }}" charset="utf-8"></script>
    </footer>
</html>
