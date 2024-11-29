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
            {{json_encode($game)}}
        </div>

        <form
            method="POST"
            action="{{ route('game-update', ['game' => $game['id']]) }}"
            class="flex flex-row h-fit w-fit"
        >
            @csrf
            @method("PATCH")

            <input
                type="text"
                name="move"
                id="move"
                placeholder="Your move."
                required
                class="w-full border-2 border-[#cba6f7] rounded-lg bg-[#313244] text-[#cdd6f4] px-1"
            />

            <!-- Submit Button -->
            <div class="ml-1">
                <button
                    type="submit"
                    class="h-full aspect-square bg-[#cba6f7] text-[#1e1e2e] font-semibold text-2xl rounded-lg hover:bg-[#b4a3e4]"
                >
                    ✓
                </button>
            </div>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </body>
</html>
