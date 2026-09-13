@extends('admin.layouts.app')

@section('title', 'Settlements')

@section('content')

    <div class="flex gap-1.5 mb-6">
        @php $tabs = ['all' => 'All', 'unsettled' => 'Unsettled', 'sent' => 'Sent', 'confirmed' => 'Confirmed']; @endphp
        @foreach ($tabs as $key => $label)
            <a href="{{ route('admin.settlements.index', ['status' => $key]) }}"
               class="rounded-full px-3.5 py-1.5 text-sm font-medium transition
                      {{ $status === $key ? 'bg-coral-500 text-white' : 'bg-white text-black/60 border border-black/10 hover:border-coral-300' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[11px] font-mono uppercase tracking-wide text-black/40">
                    <th class="px-6 py-3 font-medium">Trip</th>
                    <th class="px-6 py-3 font-medium">From → To</th>
                    <th class="px-6 py-3 font-medium">Amount</th>
                    <th class="px-6 py-3 font-medium">Method</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($settlements as $settlement)
                    <tr>
                        <td class="px-6 py-3.5">
                            <a href="{{ route('admin.trips.show', $settlement->trip) }}" class="text-coral-600 hover:text-coral-700">{{ $settlement->trip->name }}</a>
                        </td>
                        <td class="px-6 py-3.5 text-black/70">{{ $settlement->fromUser?->display_name ?? '—' }} → {{ $settlement->toUser?->display_name ?? '—' }}</td>
                        <td class="px-6 py-3.5 font-mono text-ink">₱{{ number_format($settlement->amount, 2) }}</td>
                        <td class="px-6 py-3.5 text-black/60">{{ $settlement->method ? strtoupper($settlement->method) : '—' }}</td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono bg-{{ $settlement->statusColor() }}-100 text-{{ $settlement->statusColor() }}-700">
                                {{ ucfirst($settlement->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            @if ($settlement->status !== 'confirmed')
                                <form method="POST" action="{{ route('admin.settlements.confirm', $settlement) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium px-3 py-1.5 transition">Mark confirmed</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-black/40">No settlements match this filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $settlements->links() }}</div>
@endsection
