<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\SettlementController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

        Route::get('trips', [TripController::class, 'index'])->name('trips.index');
        Route::get('trips/{trip}', [TripController::class, 'show'])->name('trips.show');
        Route::patch('trips/{trip}/status', [TripController::class, 'updateStatus'])->name('trips.status');

        Route::get('expenses', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::patch('expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
        Route::patch('expenses/{expense}/reject', [ExpenseController::class, 'reject'])->name('expenses.reject');

        Route::get('settlements', [SettlementController::class, 'index'])->name('settlements.index');
        Route::patch('settlements/{settlement}/confirm', [SettlementController::class, 'confirm'])->name('settlements.confirm');

        Route::resource('destinations', DestinationController::class)
            ->except(['show'])
            ->names('destinations');
    });
});
