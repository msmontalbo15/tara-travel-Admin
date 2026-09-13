<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status', 'pending')->toString();

        $expenses = Expense::with(['trip', 'paidBy'])
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        $counts = [
            'pending' => Expense::where('status', 'pending')->count(),
            'approved' => Expense::where('status', 'approved')->count(),
            'rejected' => Expense::where('status', 'rejected')->count(),
        ];

        return view('admin.expenses.index', [
            'expenses' => $expenses,
            'counts' => $counts,
            'status' => $status,
        ]);
    }

    public function approve(Expense $expense)
    {
        $expense->approve();

        return back()->with('status', 'Expense approved — the traveler has been notified.');
    }

    public function reject(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'rejection_note' => ['nullable', 'string', 'max:500'],
        ]);

        $expense->reject($validated['rejection_note'] ?? null);

        return back()->with('status', 'Expense rejected — the traveler has been notified.');
    }
}
