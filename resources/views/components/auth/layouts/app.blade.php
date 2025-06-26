
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Refreshner | @yield("title")</title>
        @vite('resources/css/app.css')
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    </head>
    <body class="bg-[#181818] text-[#1b1b18] h-[100vh] max-w-[800px] mx-auto">
            @yield("header")
            <main class="flex align-middle justify-center h-full">
            @yield("content")
        </main>
    </body>
</html>