<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bitmb - Local</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased dark:bg-gray-900 dark:text-gray-400">

    <div class="relative isolate overflow-hidden bg-gray-900">
        <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">1 <i class="fa-solid fa-bitcoin-sign"></i> = {{$averageFromProviders}} <i class="fa-solid fa-euro-sign"></i><br>Start using our app today.</h2>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">Incididunt sint fugiat pariatur cupidatat consectetur sit cillum anim id veniam aliqua proident excepteur commodo do ea.</p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="#" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Get started</a>
                <a href="#" class="text-sm font-semibold leading-6 text-white">Learn more <span aria-hidden="true">→</span></a>
            </div>
            </div>
        </div>
    </div>


        <div x-data="{ count: 0 }">
			<button @click="count++">Add</button>
			<span x-text="count">0</span>
		</div>


        <div class="mx-10">
            @livewire('refresh')

            <i class="fa-brands fa-bitcoin"></i>
        </div>
    </body>
</html>
