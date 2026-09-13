@extends('admin.layouts.app')

@section('title', 'Destinations')

@section('header-actions')
    <a href="{{ route('admin.destinations.create') }}" class="rounded-lg bg-coral-500 hover:bg-coral-600 text-white text-sm font-medium px-4 py-2 transition">
        Add destination
    </a>
@endsection

@section('content')

    <p class="text-sm text-black/50 mb-6">These cards feed the Explore tab in the app directly — changes here are live.</p>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($destinations as $destination)
            <div class="bg-white rounded-xl border border-black/5 p-5">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-3xl">{{ $destination->photo_emoji ?: '🌏' }}</span>
                    <div class="flex gap-1.5">
                        @if ($destination->is_trending)
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-mono bg-coral-100 text-coral-700">Trending</span>
                        @endif
                        @if ($destination->is_weekend_getaway)
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-mono bg-sky-100 text-sky-700">Weekend</span>
                        @endif
                    </div>
                </div>
                <h3 class="font-semibold text-ink mb-0.5">{{ $destination->name }}</h3>
                <p class="text-xs text-black/40 mb-3">{{ $destination->tag }} · {{ $destination->distance_from_metro ?: 'Distance not set' }}</p>
                @if ($destination->description)
                    <p class="text-sm text-black/60 mb-3 line-clamp-2">{{ $destination->description }}</p>
                @endif
                <div class="flex items-center justify-between text-xs font-mono text-black/50 mb-4">
                    <span>{{ $destination->avg_cost_range ?: '—' }}</span>
                    <span>{{ $destination->best_mode ?: '—' }}</span>
                </div>
                <div class="flex gap-2 pt-3 border-t border-black/5">
                    <a href="{{ route('admin.destinations.edit', $destination) }}"
                       class="flex-1 text-center rounded-lg border border-black/10 text-ink text-xs font-medium py-2 hover:bg-black/[0.03] transition">Edit</a>
                    <form method="POST" action="{{ route('admin.destinations.destroy', $destination) }}"
                          onsubmit="return confirm('Remove {{ addslashes($destination->name) }} from Explore?');" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full rounded-lg border border-rose-200 text-rose-600 text-xs font-medium py-2 hover:bg-rose-50 transition">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-sm text-black/40 col-span-full text-center py-10">No destinations yet — add the first one.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $destinations->links() }}</div>
@endsection
