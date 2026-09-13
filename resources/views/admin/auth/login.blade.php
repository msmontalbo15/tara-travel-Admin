<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/mobile/icon.png') }}">
    <title>Sign in · Tara Travel Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@500&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#1A1A1A',
                        canvas: '#F7F4F0',
                        earth: '#2C1A14',
                        sand: '#FAECE7',
                        coral: { 100: '#FBE2D9', 500: '#D85A30', 600: '#C24A22' },
                    },
                    fontFamily: {
                        sans: ['"DM Sans"', 'ui-sans-serif', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                },
            },
        };
    </script>
</head>
<body class="h-full bg-earth font-sans antialiased">
    <div class="min-h-full flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-sm">

            <div class="flex items-center gap-2.5 justify-center mb-8">
                <img src="{{ asset('assets/mobile/icon.png') }}" alt="Tara Travel" class="w-9 h-9 rounded-[11px] object-cover">
                <div class="text-white">
                    <p class="font-serif font-bold leading-tight tracking-tight text-2xl">Tara</p>
                    <p class="text-[11px] font-serif italic uppercase tracking-[0.2em] text-coral-300 -mt-0.5">Travel · Admin</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-xl shadow-black/20 p-7">
                <h1 class="text-2xl font-bold text-ink mb-1">Sign in</h1>
                <p class="text-sm text-black/50 mb-6">Dashboard staff only.</p>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm text-rose-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-ink/80 mb-1.5">Email</label>
                        <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-ink/80 mb-1.5">Password</label>
                        <input id="password" name="password" type="password" required
                               class="w-full rounded-lg border border-black/10 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-ink/70">
                        <input type="checkbox" name="remember" class="rounded border-black/20 text-coral-500 focus:ring-coral-500">
                        Keep me signed in
                    </label>
                    <button type="submit"
                            class="w-full rounded-lg bg-coral-500 hover:bg-coral-600 text-white text-sm font-medium py-2.5 transition">
                        Sign in
                    </button>
                </form>
            </div>

            <p class="text-center text-xs text-white/30 mt-6 font-mono">tara-travel · admin</p>
        </div>
    </div>
</body>
</html>
