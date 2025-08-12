<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <style>
            {{ file_get_contents(asset('assets/css/bootstrap.min.css')) }}
        </style>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
