<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link href="../resources/css/app.css" rel="stylesheet"> -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

        <title>Laravel</title>
        
    </head>
    <body >
    <h1 class="text-3xl font-bold underline">
        Hello world!
    </h1>
    <button class="btn btn-primary">Primary</button>
    </body>
</html>
