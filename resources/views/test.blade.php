<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME')}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased dark:bg-gray-900 dark:text-gray-400">


        <div x-data="{ count: 0 }">
			<button @click="count++">Add</button>
			<span x-text="count">0</span>
		</div>


        <div class="mx-10">
            @livewire('counter')

            <i class="fa-brands fa-bitcoin"></i>
        </div>
    </body>
</html>
