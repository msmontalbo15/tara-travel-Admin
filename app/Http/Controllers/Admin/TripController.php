<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $trips = Trip::with('owner')
            ->withCount(['members', 'expenses'])
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'ilike', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.trips.index', ['trips' => $trips]);
    }

    public function show(Trip $trip)
    {
        $trip->load([
            'owner',
            'members.user',
            'expenses' => fn ($query) => $query->latest('created_at'),
            'expenses.paidBy',
            'settlements.fromUser',
            'settlements.toUser',
            'contributions.user',
        ]);

        $trip->loadCount('itineraryStops');

        return view('admin.trips.show', ['trip' => $trip]);
    }

    /** Trip status is the only field the schema exposes for moderation (draft/planned/active/completed/archived). */
    public function updateStatus(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,planned,active,completed,archived'],
        ]);

        $trip->update($validated);

        return back()->with('status', "Trip marked {$validated['status']}.");
    }
}
