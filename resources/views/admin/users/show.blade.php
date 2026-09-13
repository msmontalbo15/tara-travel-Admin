@extends('admin.layouts.app')

@section('title', 'Traveler')

@section('content')

    <a href="{{ route('admin.users.index') }}" class="text-sm text-black/50 hover:text-ink mb-5 inline-block">← All users</a>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-black/5 p-6">
            <div class="w-14 h-14 rounded-full bg-coral-100 text-coral-700 flex items-center justify-center text-xl font-semibold mb-4">
                {{ strtoupper(substr($user->display_name ?: $user->email, 0, 1)) }}
            </div>
            <h2 class="text-lg font-semibold text-ink">{{ $user->display_name ?: '(no name set)' }}</h2>
            <p class="text-sm text-black/50 mb-4">{{ $user->email }}</p>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-black/45">Home city</dt>
                    <dd class="text-ink">{{ $user->home_city ?: '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black/45">Status</dt>
                    <dd class="text-ink">{{ $user->is_online ? 'Online now' : ($user->last_seen?->diffForHumans() ?? 'Never seen') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black/45">Health info on file</dt>
                    <dd class="text-ink">{{ $user->has_health_info ? 'Yes (encrypted)' : 'None' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black/45">Joined</dt>
                    <dd class="text-ink font-mono text-xs">{{ $user->created_at->format('M j, Y') }}</dd>
                </div>
            </dl>
            <p class="text-xs text-black/35 mt-5 pt-4 border-t border-black/5">
                Contact, GCash, and health details are AES-encrypted app-side and aren't readable from this dashboard.
            </p>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-black/5">
                    <h3 class="text-sm font-semibold">Trips owned ({{ $user->ownedTrips->count() }})</h3>
                </div>
                @forelse ($user->ownedTrips as $trip)
                    <a href="{{ route('admin.trips.show', $trip) }}" class="flex items-center justify-between px-6 py-3 text-sm hover:bg-black/[0.02] border-b border-black/5 last:border-0">
                        <span class="font-medium text-ink">{{ $trip->name }}</span>
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-mono bg-{{ $trip->statusColor() }}-100 text-{{ $trip->statusColor() }}-700">
                            {{ ucfirst($trip->status) }}
                        </span>
                    </a>
                @empty
                    <p class="px-6 py-6 text-sm text-black/40">Hasn't organized a trip yet.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-xl border border-black/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-black/5">
                    <h3 class="text-sm font-semibold">Trip memberships ({{ $user->tripMemberships->count() }})</h3>
                </div>
                @forelse ($user->tripMemberships as $membership)
                    <a href="{{ route('admin.trips.show', $membership->trip) }}" class="flex items-center justify-between px-6 py-3 text-sm hover:bg-black/[0.02] border-b border-black/5 last:border-0">
                        <span class="text-ink">{{ $membership->trip->name }}</span>
                        <span class="text-xs font-mono text-black/40">{{ collect($membership->roles)->map(fn ($r) => ucfirst($r))->join(', ') }}</span>
                    </a>
                @empty
                    <p class="px-6 py-6 text-sm text-black/40">Not a member of any trips.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
