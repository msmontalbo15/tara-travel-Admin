<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = TravelUser::withCount(['tripMemberships as trip_count'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->string('q').'%';
                $query->where(function ($q) use ($term) {
                    $q->where('display_name', 'ilike', $term)
                        ->orWhere('email', 'ilike', $term);
                });
            })
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        return view('admin.users.index', ['users' => $users]);
    }

    public function show(TravelUser $user)
    {
        $user->load([
            'tripMemberships.trip',
            'ownedTrips' => fn ($query) => $query->latest('created_at')->limit(10),
        ]);

        return view('admin.users.show', ['user' => $user]);
    }
}
