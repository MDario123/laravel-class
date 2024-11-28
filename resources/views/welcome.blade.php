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
        @if ($username == null)
            <div>
                <a href="/login" class="underline">Identify yourself</a>, stranger.
            </div>
        @else
            <div class="flex flex-row">
                <div>
                    Hello, {{$username}}!
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="border-solid border-[#cba6f7] border-[2px] rounded-lg bg-[#313244]">Logout</button>
                </form>
            </div>
        @endif
        <a href={{route('template-create')}} class="underline">Create template.</a>
        @foreach($templates as $template)
            <div>
                {{json_encode($template)}}
                <a href="{{ route('template-edit', $template['id']) }}" class="underline">Create from.</a>
            </div>
        @endforeach
    </body>
</html>
