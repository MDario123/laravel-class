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
    <div class="flex items-center justify-center h-screen">
        <!-- Form Container -->
        <form
            method="POST"
            action="{{ route('game-store', ['template_id' => $template_id]) }}"
            class="flex flex-col h-fit w-fit bg-[#313244] p-4 border-2 border-solid border-[#cba6f7] rounded-lg"
        >
            @csrf

            <div>
                <label for="player2's username" class="block text-sm">Player2's username</label>
                <input
                    type="text"
                    name="player2"
                    id="player2's username"
                    placeholder="Who is your beloved player2?"
                    required
                    class="w-full border-2 border-[#cba6f7] rounded-lg bg-[#313244] text-[#cdd6f4] px-2 py-1"
                />
            </div>

            <!-- Submit Button -->
            <div class="mt-4">
                <button
                    type="submit"
                    class="w-full bg-[#cba6f7] text-[#1e1e2e] font-semibold py-2 rounded-lg hover:bg-[#b4a3e4]"
                >
                    Submit
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </button>
            </div>
        </form>
    </div>
</body>
