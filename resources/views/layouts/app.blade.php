<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="soft">
    <head>
        @include("includes.head")
    </head>
    <body>
        @include("includes.header")
        <div class="flex items-center justify-center-safe content-center mt-8">
            @yield("content")
        </div>
    </body>
    <footer>
        @include("includes.footer")
    </footer>
</html>
