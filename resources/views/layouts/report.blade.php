<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <style>
            {{ file_get_contents(asset('assets/css/bootstrap.min.css')) }}
        </style>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
