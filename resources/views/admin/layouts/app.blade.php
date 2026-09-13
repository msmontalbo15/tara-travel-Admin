<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/mobile/icon.png') }}">
    <title>@yield('title', 'Dashboard') · Tara Travel Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500;600&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#1A1A1A',
                        canvas: '#F7F4F0',
                        sand: '#FAECE7',
                        earth: '#2C1A14',
                        coral: {
                            50: '#FDF2EE',
                            100: '#FBE2D9',
                            200: '#F5C3AE',
                            300: '#EDA88D',
                            400: '#E17A50',
                            500: '#D85A30',
                            600: '#C24A22',
                            700: '#9E3B1A',
                        },
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        h1, h2, h3 { font-family: "Playfair Display", Georgia, serif; }
        input:focus, select:focus, textarea:focus {
            border-color: #D85A30 !important;
            box-shadow: 0 0 0 2px rgba(216, 90, 48, 0.16);
        }
    </style>
</head>
<body class="h-full bg-canvas text-ink font-sans antialiased">
    <div class="min-h-full lg:flex" x-data="{ sidebarOpen: false }">

        @php
            $navSections = [
                'Overview' => [
                    ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'label' => 'Dashboard'],
                ],
                'Oversight' => [
                    ['route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'label' => 'Users'],
                    ['route' => 'admin.trips.index', 'pattern' => 'admin.trips.*', 'label' => 'Trips'],
                    ['route' => 'admin.expenses.index', 'pattern' => 'admin.expenses.*', 'label' => 'Expenses'],
                    ['route' => 'admin.settlements.index', 'pattern' => 'admin.settlements.*', 'label' => 'Settlements'],
                ],
                'Content' => [
                    ['route' => 'admin.destinations.index', 'pattern' => 'admin.destinations.*', 'label' => 'Destinations'],
                ],
            ];
        @endphp

        {{-- Sidebar content is duplicated below for desktop (always visible)
             and mobile (slide-over) — kept as plain markup rather than a
             shared component so this renders correctly with zero risk of
             a component-resolution quirk in an unverified fresh install. --}}

        <aside class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0 bg-earth text-white">
            <div class="flex items-center gap-2.5 px-6 py-6">
                <img src="{{ asset('assets/mobile/icon.png') }}" alt="Tara Travel" class="w-8 h-8 rounded-[10px] object-cover shrink-0">
                <div>
                    <p class="font-serif text-xl font-bold leading-tight tracking-tight">Tara</p>
                    <p class="font-serif text-[11px] italic uppercase tracking-[0.2em] text-coral-300">Travel · Admin</p>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-2 space-y-6">
                @foreach ($navSections as $section => $items)
                    <div>
                        <p class="px-3 mb-1.5 text-[11px] font-mono uppercase tracking-widest text-white/35">{{ $section }}</p>
                        <div class="space-y-0.5">
                            @foreach ($items as $item)
                                @php $active = request()->routeIs($item['pattern']); @endphp
                                <a href="{{ route($item['route']) }}"
                                   class="flex items-center gap-2.5 rounded-md px-3 py-2 text-sm transition
                                          {{ $active ? 'bg-white/10 text-white font-medium border-l-2 border-coral-500 -ml-px pl-[11px]' : 'text-white/65 hover:bg-white/5 hover:text-white' }}">
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            <div class="px-3 py-4 border-t border-white/10">
                <div class="px-3 py-2 text-sm">
                    <p class="text-white/90 truncate">{{ auth('admin')->user()->name }}</p>
                    <p class="text-white/40 text-xs truncate">{{ auth('admin')->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left rounded-md px-3 py-2 text-sm text-white/65 hover:bg-white/5 hover:text-white transition">
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Mobile sidebar --}}
        <div x-cloak x-show="sidebarOpen" class="lg:hidden fixed inset-0 z-40" x-transition.opacity>
            <div class="absolute inset-0 bg-earth/60" @click="sidebarOpen = false"></div>
            <aside class="relative w-64 h-full bg-earth text-white flex flex-col" @click.outside="sidebarOpen = false">
                <div class="flex items-center gap-2.5 px-6 py-6">
                    <img src="{{ asset('assets/mobile/icon.png') }}" alt="Tara Travel" class="w-8 h-8 rounded-[10px] object-cover shrink-0">
                    <div>
                        <p class="font-serif text-xl font-bold leading-tight tracking-tight">Tara</p>
                        <p class="font-serif text-[11px] italic uppercase tracking-[0.2em] text-coral-300">Travel · Admin</p>
                    </div>
                </div>
                <nav class="flex-1 overflow-y-auto px-3 py-2 space-y-6">
                    @foreach ($navSections as $section => $items)
                        <div>
                            <p class="px-3 mb-1.5 text-[11px] font-mono uppercase tracking-widest text-white/35">{{ $section }}</p>
                            <div class="space-y-0.5">
                                @foreach ($items as $item)
                                    @php $active = request()->routeIs($item['pattern']); @endphp
                                    <a href="{{ route($item['route']) }}"
                                       class="flex items-center gap-2.5 rounded-md px-3 py-2 text-sm transition
                                              {{ $active ? 'bg-white/10 text-white font-medium border-l-2 border-coral-500 -ml-px pl-[11px]' : 'text-white/65 hover:bg-white/5 hover:text-white' }}">
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </nav>
                <div class="px-3 py-4 border-t border-white/10">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left rounded-md px-3 py-2 text-sm text-white/65 hover:bg-white/5 hover:text-white transition">
                            Sign out
                        </button>
                    </form>
                </div>
            </aside>
        </div>

        <div class="flex-1 lg:pl-64 min-w-0 flex flex-col min-h-full">
            <header class="sticky top-0 z-30 bg-canvas/90 backdrop-blur border-b border-black/5">
                <div class="flex items-center justify-between px-4 lg:px-8 py-4">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = true" class="lg:hidden -ml-1 p-1.5 rounded-md hover:bg-black/5">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <h1 class="text-lg font-semibold tracking-tight">@yield('title', 'Dashboard')</h1>
                    </div>
                    @hasSection('header-actions')
                        <div>@yield('header-actions')</div>
                    @endif
                </div>
            </header>

            <main class="flex-1 px-4 lg:px-8 py-6 lg:py-8">
                @if (session('status'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <ul class="list-disc pl-4 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
