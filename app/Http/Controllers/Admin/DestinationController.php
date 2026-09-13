<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::orderByDesc('created_at')->paginate(20);

        return view('admin.destinations.index', ['destinations' => $destinations]);
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        Destination::create($this->validated($request));

        return redirect()->route('admin.destinations.index')->with('status', 'Destination published.');
    }

    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', ['destination' => $destination]);
    }

    public function update(Request $request, Destination $destination)
    {
        $destination->update($this->validated($request));

        return redirect()->route('admin.destinations.index')->with('status', 'Destination updated.');
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();

        return back()->with('status', 'Destination removed.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:80'],
            'distance_from_metro' => ['nullable', 'string', 'max:80'],
            'best_mode' => ['nullable', 'string', 'max:80'],
            'avg_cost_range' => ['nullable', 'string', 'max:80'],
            'photo_emoji' => ['nullable', 'string', 'max:8'],
            'tag' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:1000'],
            'recommended_reason' => ['nullable', 'string', 'max:200'],
            'best_time_to_visit' => ['nullable', 'string', 'max:80'],
        ]);

        // Checkboxes: an unchecked box is simply absent from the request,
        // not "leave unchanged". Using validate()'s 'sometimes' rule here
        // would silently drop the key on update — so unchecking "Trending"
        // would never actually turn it off. $request->boolean() normalizes
        // missing/"0"/"1" consistently for both create and edit.
        $data['is_trending'] = $request->boolean('is_trending');
        $data['is_weekend_getaway'] = $request->boolean('is_weekend_getaway');
        $data['is_recommended'] = $request->boolean('is_recommended');

        return $data;
    }
}
