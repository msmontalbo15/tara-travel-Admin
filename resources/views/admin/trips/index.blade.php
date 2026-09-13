@extends('admin.layouts.app')

@section('title', 'Trips')

@section('content')

    <form method="GET" class="mb-6 flex flex-wrap gap-2 max-w-2xl">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search trip name…"
               class="flex-1 min-w-[200px] rounded-lg border border-black/10 px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
        <select name="status" class="rounded-lg border border-black/10 px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-coral-500 focus:border-coral-500">
            <option value="">All statuses</option>
            @foreach (['draft', 'planned', 'active', 'completed', 'archived'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-lg bg-coral-500 text-white text-sm font-medium px-4 py-2 hover:bg-coral-600 transition">Filter</button>
    </form>

    <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[11px] font-mono uppercase tracking-wide text-black/40">
                    <th class="px-6 py-3 font-medium">Trip</th>
                    <th class="px-6 py-3 font-medium">Owner</th>
                    <th class="px-6 py-3 font-medium">Members</th>
                    <th class="px-6 py-3 font-medium">Expenses</th>
                    <th class="px-6 py-3 font-medium">Dates</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($trips as $trip)
                    <tr class="hover:bg-black/[0.02] cursor-pointer" onclick="window.location='{{ route('admin.trips.show', $trip) }}'">
                        <td class="px-6 py-3.5">
                            <p class="font-medium text-ink">{{ $trip->name }}</p>
                            <p class="text-xs text-black/40">{{ $trip->destination }}</p>
                        </td>
                        <td class="px-6 py-3.5 text-black/70">{{ $trip->owner?->display_name ?? '—' }}</td>
                        <td class="px-6 py-3.5 font-mono text-black/70">{{ $trip->members_count }}</td>
                        <td class="px-6 py-3.5 font-mono text-black/70">{{ $trip->expenses_count }}</td>
                        <td class="px-6 py-3.5 font-mono text-xs text-black/50">{{ $trip->start_date->format('M j') }} – {{ $trip->end_date->format('M j, Y') }}</td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono bg-{{ $trip->statusColor() }}-100 text-{{ $trip->statusColor() }}-700">
                                {{ ucfirst($trip->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-black/40">No trips match those filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $trips->links() }}</div>
@endsection
