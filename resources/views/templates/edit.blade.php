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
            action="{{ route('template-update', $template->id) }}"
            class="flex flex-col h-fit w-fit bg-[#313244] p-4 border-2 border-solid border-[#cba6f7] rounded-lg"
        >
            @csrf
            @method('PUT')

            <!-- Input Fields -->
            <div class="space-x-2 flex flex-row">
                <!-- X Coordinate -->
                <div>
                    <label for="x" class="block text-sm">X Size</label>
                    <input
                        type="text"
                        name="size_x"
                        id="size_x"
                        placeholder="11"
                        value={{$template->size_x}}
                        required
                        class="w-full border-2 border-[#cba6f7] rounded-lg bg-[#313244] text-[#cdd6f4] px-2 py-1"
                    />
                </div>

                <!-- Y Coordinate -->
                <div>
                    <label for="y" class="block text-sm">Y Size</label>
                    <input
                        type="text"
                        name="size_y"
                        id="size_y"
                        placeholder="11"
                        value={{$template->size_y}}
                        required
                        class="w-full border-2 border-[#cba6f7] rounded-lg bg-[#313244] text-[#cdd6f4] px-2 py-1"
                    />
                </div>
            </div>

            <!-- Resources -->
            <div class="mt-4">
                <label for="resources" class="block text-sm">Resources (JSON)</label>
                <textarea
                    name="resources"
                    id="resources"
                    required
                    class="w-full border-2 border-[#cba6f7] rounded-lg bg-[#313244] text-[#cdd6f4] px-2 py-1"
                >
                {{json_encode($template->resources)}}
                </textarea>
            </div>

            <!-- Extra Rules -->
            <div class="mt-4">
                <label for="extra_rules" class="block text-sm">Extra Rules (JSON)</label>
                <input
                    type="text"
                    name="extra_rules"
                    id="extra_rules"
                    placeholder="{}"
                    value={{$template->extra_rules}}
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
