<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css' )
        <title>
            {{config('app.name', 'Habit Tracker')}}
        </title>
    </head>

    <body class="bg-[#FFEDD6]">

        {{-- HEADER --}}
        <x-header/>
        {{ $slot}}
        {{-- FOOTER --}}
        <x-footer/>
    </body>
</html>
