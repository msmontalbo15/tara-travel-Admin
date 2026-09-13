<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Expense;
use App\Models\Settlement;
use App\Models\Trip;
use App\Models\TravelUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => TravelUser::count(),
            'total_trips' => Trip::count(),
            'active_trips' => Trip::where('status', 'active')->count(),
            'total_expense_volume' => (float) Expense::where('status', 'approved')->sum('amount'),
            'pending_expenses' => Expense::where('status', 'pending')->count(),
            'unsettled_amount' => (float) Settlement::where('status', '!=', 'confirmed')->sum('amount'),
            'total_destinations' => Destination::count(),
        ];

        $since = Carbon::now()->subDays(29)->startOfDay();

        $signups = $this->dailySeries(TravelUser::query(), $since);
        $tripsCreated = $this->dailySeries(Trip::query(), $since);

        $topDestinations = Trip::select('destination', DB::raw('count(*) as trip_count'))
            ->groupBy('destination')
            ->orderByDesc('trip_count')
            ->limit(6)
            ->get();

        $recentTrips = Trip::with('owner')
            ->latest('created_at')
            ->limit(6)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'signupSeries' => $signups,
            'tripSeries' => $tripsCreated,
            'topDestinations' => $topDestinations,
            'recentTrips' => $recentTrips,
        ]);
    }

    /**
     * Builds a zero-filled last-30-days count series for a chart, since a
     * bare group-by would silently skip days with no rows.
     */
    private function dailySeries($query, Carbon $since): array
    {
        $rows = $query
            ->where('created_at', '>=', $since)
            ->select(DB::raw('date(created_at) as day'), DB::raw('count(*) as total'))
            ->groupBy('day')
            ->pluck('total', 'day');

        $labels = [];
        $values = [];

        for ($date = $since->copy(); $date->lte(Carbon::now()); $date->addDay()) {
            $key = $date->toDateString();
            $labels[] = $date->format('M j');
            $values[] = (int) ($rows[$key] ?? 0);
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
