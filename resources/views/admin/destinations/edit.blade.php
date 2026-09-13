@extends('admin.layouts.app')

@section('title', 'Edit destination')

@section('content')

    <a href="{{ route('admin.destinations.index') }}" class="text-sm text-black/50 hover:text-ink mb-5 inline-block">← All destinations</a>

    <div class="bg-white rounded-xl border border-black/5 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.destinations.update', $destination) }}">
            @csrf
            @method('PUT')
            @include('admin.destinations._form', ['destination' => $destination])
            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-lg bg-coral-500 hover:bg-coral-600 text-white text-sm font-medium px-5 py-2.5 transition">
                    Save changes
                </button>
                <a href="{{ route('admin.destinations.index') }}" class="text-sm text-black/50 hover:text-ink">Cancel</a>
            </div>
        </form>
    </div>
@endsection
