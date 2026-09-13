@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        @php
            $cards = [
                ['label' => 'Travelers', 'value' => number_format($stats['total_users'])],
                ['label' => 'Trips', 'value' => number_format($stats['total_trips'])],
                ['label' => 'Active trips', 'value' => number_format($stats['active_trips'])],
                ['label' => 'Approved volume', 'value' => '₱'.number_format($stats['total_expense_volume'], 0)],
                ['label' => 'Pending review', 'value' => number_format($stats['pending_expenses']), 'flag' => $stats['pending_expenses'] > 0],
                ['label' => 'Unsettled', 'value' => '₱'.number_format($stats['unsettled_amount'], 0)],
            ];
        @endphp
        @foreach ($cards as $card)
            <div class="bg-white rounded-xl border border-black/5 p-4 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 {{ ($card['flag'] ?? false) ? 'bg-amber-500' : 'bg-coral-500' }}"></div>
                <p class="text-[11px] font-mono uppercase tracking-wide text-black/40 mb-1.5 pl-2">{{ $card['label'] }}</p>
                <p class="text-xl font-semibold font-mono pl-2 {{ ($card['flag'] ?? false) ? 'text-amber-600' : 'text-ink' }}">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-xl border border-black/5 p-6">
            <h2 class="text-sm font-semibold mb-4">Growth, last 30 days</h2>
            <canvas id="growthChart" height="120"></canvas>
        </div>
        <div class="bg-white rounded-xl border border-black/5 p-6">
            <h2 class="text-sm font-semibold mb-4">Top destinations by trip count</h2>
            <ul class="space-y-3">
                @forelse ($topDestinations as $d)
                    <li class="flex items-center justify-between text-sm">
                        <span class="truncate pr-2">{{ $d->destination }}</span>
                        <span class="font-mono text-black/50 shrink-0">{{ $d->trip_count }}</span>
                    </li>
                @empty
                    <li class="text-sm text-black/40">No trips yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
        <div class="px-6 py-4 border-b border-black/5 flex items-center justify-between">
            <h2 class="text-sm font-semibold">Recent trips</h2>
            <a href="{{ route('admin.trips.index') }}" class="text-xs font-medium text-coral-600 hover:text-coral-700">View all →</a>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[11px] font-mono uppercase tracking-wide text-black/40">
                    <th class="px-6 py-2.5 font-medium">Trip</th>
                    <th class="px-6 py-2.5 font-medium">Owner</th>
                    <th class="px-6 py-2.5 font-medium">Status</th>
                    <th class="px-6 py-2.5 font-medium">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($recentTrips as $trip)
                    <tr class="hover:bg-black/[0.02] cursor-pointer" onclick="window.location='{{ route('admin.trips.show', $trip) }}'">
                        <td class="px-6 py-3">
                            <p class="font-medium text-ink">{{ $trip->name }}</p>
                            <p class="text-xs text-black/40">{{ $trip->destination }}</p>
                        </td>
                        <td class="px-6 py-3 text-black/70">{{ $trip->owner?->display_name ?? '—' }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono bg-{{ $trip->statusColor() }}-100 text-{{ $trip->statusColor() }}-700">
                                {{ ucfirst($trip->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-black/50 font-mono text-xs">{{ $trip->created_at->format('M j, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-black/40">No trips yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('growthChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($signupSeries['labels']),
                datasets: [
                    {
                        label: 'New travelers',
                        data: @json($signupSeries['values']),
                        borderColor: '#D85A30',
                        backgroundColor: 'rgba(216, 90, 48, 0.08)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 0,
                        borderWidth: 2,
                    },
                    {
                        label: 'Trips created',
                        data: @json($tripSeries['values']),
                        borderColor: '#2C1A14',
                        backgroundColor: 'rgba(23, 24, 28, 0.04)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 0,
                        borderWidth: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 8, usePointStyle: true,                     font: { family: 'DM Sans', size: 11 } } },
                },
                scales: {
                    x: { ticks: { font: { family: 'JetBrains Mono', size: 10 } }, grid: { display: false } },
                    y: { beginAtZero: true, ticks: { precision: 0, font: { family: 'JetBrains Mono', size: 10 } }, grid: { color: 'rgba(0,0,0,0.05)' } },
                },
            },
        });
    </script>
@endsection
