<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? "Laravel Refreshner"}}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    </head>
    <body class="bg-[#181818] text-[#1b1b18] min-h-[100vh]  max-w-[800px] mx-auto scroll-smooth">
        <livewire:navigation />
        {{ $slot }}
       @if (session('success'))
            <div class="py-3 px-5 bg-red-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div id="backTop" class="fixed bottom-5 right-5 border border-gray-400 text-gray-200 py-3 px-4 cursor-pointer bg-gray-950" onclick="window.scrollTo({top:0,left:0,behavior:'smooth'})">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 15 15"><path fill="currentColor" fill-rule="evenodd" d="M1.5 1.05a.45.45 0 1 0 0 .9h12a.45.45 0 1 0 0-.9zm2.432 6.382a.45.45 0 1 0 .636.636L7.05 5.586V13.5a.45.45 0 0 0 .9 0V5.586l2.482 2.482a.45.45 0 1 0 .636-.636l-3.25-3.25a.45.45 0 0 0-.636 0z" clip-rule="evenodd"/></svg>
        </div>
        <script>
            let el = document.getElementById("backTop");
            
            document.addEventListener("scroll", (e) => {
                el.style.display = (this.scrollY <= 100) ? "none" : "block";
            })
        </script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    </body>
</html>
