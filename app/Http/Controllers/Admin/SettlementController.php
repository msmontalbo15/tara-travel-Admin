<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settlement;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status', 'all')->toString();

        $settlements = Settlement::with(['trip', 'fromUser', 'toUser'])
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        return view('admin.settlements.index', [
            'settlements' => $settlements,
            'status' => $status,
        ]);
    }

    public function confirm(Settlement $settlement)
    {
        $settlement->markConfirmed();

        return back()->with('status', 'Settlement marked confirmed.');
    }
}
