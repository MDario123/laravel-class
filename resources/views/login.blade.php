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
    <body class="bg-[#1e1e2e] h-screen text-[#cdd6f4] text-lg">
        <div class="flex items-center justify-center h-screen">
            <form method="POST" action="{{ route('login') }}" class="flex justify-between flex-col h-72 w-56 bg-[#313244] pb-4 pt-4 pl-3 pr-3 border-solid border-[#cba6f7] border-[2px] rounded-lg">
                @csrf
                <div>
                    <div><label>Username:</label></div>
                    <input type="username" name="username" placeholder="username" required class="w-full border-solid border-[#cba6f7] border-[2px] rounded-lg bg-[#313244] text-[#cdd6f4] pl-1 pr-1 pb-0.5">
                </div>
                <div>
                    <div><label>Password:</label></div>
                    <input type="password" name="password" placeholder="password" required class="w-full border-solid border-[#cba6f7] border-[2px] rounded-lg bg-[#313244] text-[#cdd6f4] pl-1 pr-1 pb-0.5">
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </body>
</html>
