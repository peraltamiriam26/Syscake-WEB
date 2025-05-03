<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include("includes.head")
    </head>
    <body >
        @include("includes.header")
        @yield("content")
    </body>
    <footer>
        @include("includes.footer")
    </footer>
</html>
