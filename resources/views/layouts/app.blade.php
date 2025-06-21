<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="soft">
    <head>
        @include("includes.head")
        @livewireStyles
    </head>
    <body class="flex flex-col min-h-screen">
        @include("includes.header")
        <div class="flex items-center justify-center-safe content-center flex-grow max-w-screen-lg mx-auto">
            @yield("content")
        </div>
        <footer class="footer bg-base-200 absolute -bottom-px sticky start-0 w-full px-6 py-4">
            @include("includes.footer")
        </footer>
        @livewireScripts
    </body>
</html>
