@extends('admin.layouts.app')

@section('title', 'Expenses')

@section('content')

    <div class="flex gap-1.5 mb-6">
        @php
            $tabs = [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'all' => 'All',
            ];
        @endphp
        @foreach ($tabs as $key => $label)
            <a href="{{ route('admin.expenses.index', ['status' => $key]) }}"
               class="rounded-full px-3.5 py-1.5 text-sm font-medium transition
                      {{ $status === $key ? 'bg-coral-500 text-white' : 'bg-white text-black/60 border border-black/10 hover:border-coral-300' }}">
                {{ $label }}
                @if ($key !== 'all')
                    <span class="font-mono text-xs opacity-70">{{ $counts[$key] }}</span>
                @endif
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border border-black/5 overflow-hidden" x-data="{ rejecting: null }">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[11px] font-mono uppercase tracking-wide text-black/40">
                    <th class="px-6 py-3 font-medium">Expense</th>
                    <th class="px-6 py-3 font-medium">Trip</th>
                    <th class="px-6 py-3 font-medium">Paid by</th>
                    <th class="px-6 py-3 font-medium">Amount</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($expenses as $expense)
                    <tr>
                        <td class="px-6 py-3.5">
                            <p class="font-medium text-ink">{{ $expense->description }}</p>
                            <p class="text-xs text-black/40">{{ ucfirst($expense->category) }}</p>
                        </td>
                        <td class="px-6 py-3.5">
                            <a href="{{ route('admin.trips.show', $expense->trip) }}" class="text-coral-600 hover:text-coral-700">{{ $expense->trip->name }}</a>
                        </td>
                        <td class="px-6 py-3.5 text-black/70">{{ $expense->paidBy?->display_name ?? '—' }}</td>
                        <td class="px-6 py-3.5 font-mono text-ink">₱{{ number_format($expense->amount, 2) }}</td>
                        <td class="px-6 py-3.5">
                            @if ($expense->status === 'pending')
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.expenses.approve', $expense) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium px-3 py-1.5 transition">Approve</button>
                                    </form>
                                    <button type="button" @click="rejecting = rejecting === '{{ $expense->id }}' ? null : '{{ $expense->id }}'"
                                            class="rounded-lg bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-medium px-3 py-1.5 transition">
                                        Reject
                                    </button>
                                </div>
                                <div x-cloak x-show="rejecting === '{{ $expense->id }}'" class="mt-2">
                                    <form method="POST" action="{{ route('admin.expenses.reject', $expense) }}" class="flex items-center gap-2">
                                        @csrf @method('PATCH')
                                        <input type="text" name="rejection_note" placeholder="Reason (optional)"
                                               class="flex-1 rounded-lg border border-black/10 px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-rose-400">
                                        <button type="submit" class="rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium px-3 py-1.5 transition shrink-0">Confirm</button>
                                    </form>
                                </div>
                            @else
                                <div class="text-right">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono bg-{{ $expense->statusColor() }}-100 text-{{ $expense->statusColor() }}-700">
                                        {{ ucfirst($expense->status) }}
                                    </span>
                                    @if ($expense->rejection_note)
                                        <p class="text-xs text-black/40 mt-1 max-w-[220px] ml-auto">{{ $expense->rejection_note }}</p>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-10 text-center text-black/40">Nothing here.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $expenses->links() }}</div>
@endsection
