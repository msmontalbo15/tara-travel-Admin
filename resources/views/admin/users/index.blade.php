@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')

    <form method="GET" class="mb-6 flex gap-2 max-w-md">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or email…"
               class="flex-1 rounded-lg border border-black/10 px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
        <button type="submit" class="rounded-lg bg-coral-500 text-white text-sm font-medium px-4 py-2 hover:bg-coral-600 transition">Search</button>
    </form>

    <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[11px] font-mono uppercase tracking-wide text-black/40">
                    <th class="px-6 py-3 font-medium">Traveler</th>
                    <th class="px-6 py-3 font-medium">Home city</th>
                    <th class="px-6 py-3 font-medium">Trips</th>
                    <th class="px-6 py-3 font-medium">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($users as $user)
                    <tr class="hover:bg-black/[0.02] cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user) }}'">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-coral-100 text-coral-700 flex items-center justify-center text-xs font-semibold shrink-0">
                                    {{ strtoupper(substr($user->display_name ?: $user->email, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-ink truncate">{{ $user->display_name ?: '(no name set)' }}</p>
                                    <p class="text-xs text-black/40 truncate">{{ $user->email }}</p>
                                </div>
                                @if ($user->is_online)
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0" title="Online"></span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-black/70">{{ $user->home_city ?: '—' }}</td>
                        <td class="px-6 py-3.5 font-mono text-black/70">{{ $user->trip_count }}</td>
                        <td class="px-6 py-3.5 font-mono text-xs text-black/50">{{ $user->created_at->format('M j, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-10 text-center text-black/40">No travelers match that search.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
@endsection
