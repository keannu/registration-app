<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registration App Dashboard</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    </head>
    <body>
        <div id="dashboard">

        </div>
    </body>
    <footer>
        <script type="text/javascript" src="{{ mix('/js/dashboard.js') }}" charset="utf-8"></script>
        <script type="text/javascript">
            sessionStorage.setItem('user_no', '{{ $user_no }}');
            sessionStorage.setItem('username', '{{ $username }}');
            sessionStorage.setItem('is_admin', '{{ $is_admin }}');
        </script>
    </footer>
</html>
