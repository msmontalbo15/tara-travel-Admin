@extends('admin.layouts.app')

@section('title', 'Add destination')

@section('content')

    <a href="{{ route('admin.destinations.index') }}" class="text-sm text-black/50 hover:text-ink mb-5 inline-block">← All destinations</a>

    <div class="bg-white rounded-xl border border-black/5 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.destinations.store') }}">
            @csrf
            @include('admin.destinations._form', ['destination' => null])
            <button type="submit" class="rounded-lg bg-coral-500 hover:bg-coral-600 text-white text-sm font-medium px-5 py-2.5 transition">
                Publish destination
            </button>
        </form>
    </div>
@endsection
