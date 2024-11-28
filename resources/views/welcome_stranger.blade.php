<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Game</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Import tailwind -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#1e1e2e] h-screen text-[#cdd6f4]">
        <div>
            <a href="/login" class="underline">Identify yourself</a>, stranger.
        </div>
        <div>
            <a href={{route('template-create')}} class="underline">Create template.</a>
        </div>
        @foreach($templates as $template)
            <div>
                <a href="{{ route('template-edit', $template['id']) }}" class="underline">Create from.</a>
                {{json_encode($template)}}
            </div>
        @endforeach
    </body>
</html>
