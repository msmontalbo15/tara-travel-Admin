@extends('admin.layouts.app')

@section('title', 'Trip')

@section('content')

    <a href="{{ route('admin.trips.index') }}" class="text-sm text-black/50 hover:text-ink mb-5 inline-block">← All trips</a>

    <div class="bg-white rounded-xl border border-black/5 p-6 mb-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    @if ($trip->cover_emoji)<span class="text-xl">{{ $trip->cover_emoji }}</span>@endif
                    <h2 class="text-lg font-semibold text-ink">{{ $trip->name }}</h2>
                </div>
                <p class="text-sm text-black/50">{{ $trip->destination }} · {{ $trip->start_date->format('M j') }} – {{ $trip->end_date->format('M j, Y') }}</p>
            </div>
            <form method="POST" action="{{ route('admin.trips.status', $trip) }}" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <select name="status" class="rounded-lg border border-black/10 px-3 py-1.5 text-xs font-mono bg-white focus:outline-none focus:ring-2 focus:ring-coral-500">
                    @foreach (['draft', 'planned', 'active', 'completed', 'archived'] as $s)
                        <option value="{{ $s }}" @selected($trip->status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-coral-500 hover:bg-coral-600 text-white text-xs font-medium px-3 py-1.5 transition">Update</button>
            </form>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-black/5">
            <div>
                <p class="text-[11px] font-mono uppercase tracking-wide text-black/40 mb-1">Owner</p>
                <p class="text-sm text-ink">{{ $trip->owner?->display_name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-[11px] font-mono uppercase tracking-wide text-black/40 mb-1">Budget</p>
                <p class="text-sm font-mono text-ink">{{ $trip->currency }} {{ number_format($trip->budget, 0) }}</p>
            </div>
            <div>
                <p class="text-[11px] font-mono uppercase tracking-wide text-black/40 mb-1">Type / transport</p>
                <p class="text-sm text-ink">{{ ucfirst($trip->type) }} · {{ ucfirst($trip->transport_mode) }}</p>
            </div>
            <div>
                <p class="text-[11px] font-mono uppercase tracking-wide text-black/40 mb-1">Itinerary stops</p>
                <p class="text-sm font-mono text-ink">{{ $trip->itinerary_stops_count }}</p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-black/5 overflow-hidden lg:col-span-1">
            <div class="px-6 py-4 border-b border-black/5">
                <h3 class="text-sm font-semibold">Members ({{ $trip->members->count() }})</h3>
            </div>
            @forelse ($trip->members as $member)
                <div class="flex items-center justify-between px-6 py-3 text-sm border-b border-black/5 last:border-0">
                    <span class="text-ink truncate pr-2">{{ $member->user?->display_name ?? 'Unknown' }}</span>
                    <span class="text-xs font-mono text-black/40 shrink-0">{{ collect($member->roles)->map(fn ($r) => ucfirst($r))->join(', ') }}</span>
                </div>
            @empty
                <p class="px-6 py-6 text-sm text-black/40">No members yet.</p>
            @endforelse
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-black/5 flex items-center justify-between">
                    <h3 class="text-sm font-semibold">Expenses ({{ $trip->expenses->count() }})</h3>
                    <a href="{{ route('admin.expenses.index') }}" class="text-xs font-medium text-coral-600 hover:text-coral-700">Oversight queue →</a>
                </div>
                @forelse ($trip->expenses as $expense)
                    <div class="flex items-center justify-between px-6 py-3 text-sm border-b border-black/5 last:border-0">
                        <div class="min-w-0 pr-3">
                            <p class="text-ink truncate">{{ $expense->description }}</p>
                            <p class="text-xs text-black/40">Paid by {{ $expense->paidBy?->display_name ?? '—' }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-mono text-ink">₱{{ number_format($expense->amount, 0) }}</p>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-mono bg-{{ $expense->statusColor() }}-100 text-{{ $expense->statusColor() }}-700">
                                {{ ucfirst($expense->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-6 text-sm text-black/40">No expenses logged.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-black/5">
                    <h3 class="text-sm font-semibold">Settlements ({{ $trip->settlements->count() }})</h3>
                </div>
                @forelse ($trip->settlements as $settlement)
                    <div class="flex items-center justify-between px-6 py-3 text-sm border-b border-black/5 last:border-0">
                        <span class="text-ink">{{ $settlement->fromUser?->display_name ?? '—' }} → {{ $settlement->toUser?->display_name ?? '—' }}</span>
                        <div class="text-right shrink-0">
                            <span class="font-mono text-ink">₱{{ number_format($settlement->amount, 0) }}</span>
                            <span class="ml-2 inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-mono bg-{{ $settlement->statusColor() }}-100 text-{{ $settlement->statusColor() }}-700">
                                {{ ucfirst($settlement->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-6 text-sm text-black/40">No settlements recorded.</p>
                @endforelse
            </div>

            @if ($trip->contributions->isNotEmpty())
                <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                    <div class="px-6 py-4 border-b border-black/5">
                        <h3 class="text-sm font-semibold">Contributions ({{ $trip->contributions->count() }})</h3>
                    </div>
                    @foreach ($trip->contributions as $contribution)
                        <div class="flex items-center justify-between px-6 py-3 text-sm border-b border-black/5 last:border-0">
                            <div class="min-w-0 pr-3">
                                <p class="text-ink truncate">{{ $contribution->reason }}</p>
                                <p class="text-xs text-black/40">{{ $contribution->user?->display_name ?? '—' }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="font-mono text-ink">₱{{ number_format($contribution->amount, 0) }}</p>
                                <p class="text-[11px] text-black/40">{{ $contribution->confirmed ? 'Confirmed' : 'Unconfirmed' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
