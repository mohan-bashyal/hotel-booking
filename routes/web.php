<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\HotelController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\Admins\AdDashboardController;
use App\Http\Controllers\Admins\RoomTypeController;
use App\Http\Controllers\Admins\RoomController;
use App\Http\Controllers\Admins\StaffController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Staff\BookingController as StaffBookingController;
use App\Http\Controllers\BookingNotificationController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| ROLE BASED LOGIN (NO BREEZE AUTH)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/login/{role}', [AuthenticatedSessionController::class, 'create'])
    ->whereIn('role', ['superadmin', 'admin', 'staff']);

Route::post('/login/{role}', [AuthenticatedSessionController::class, 'store'])
    ->whereIn('role', ['superadmin', 'admin', 'staff']);

/*
|--------------------------------------------------------------------------
| DASHBOARDS (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('hotels', HotelController::class)->except(['show']);

        Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
        Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
        Route::patch('/admins/{admin}/toggle', [AdminController::class, 'toggle'])->name('admins.toggle');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
    });

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('room-types', RoomTypeController::class)->except(['show']);
        Route::resource('rooms', RoomController::class)->except(['show']);
        Route::patch('rooms/{room}/toggle', [RoomController::class, 'toggle'])
            ->name('rooms.toggle');

        // Staff Management (corrected/clean)
        Route::resource('staffs', StaffController::class)->except(['show']);
        Route::patch('staffs/{staff}/toggle', [StaffController::class, 'toggle'])
            ->name('staffs.toggle');
    });

Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffBookingController::class, 'index'])->name('dashboard');
        Route::get('/bookings', [StaffBookingController::class, 'index'])->name('bookings.index');
        Route::patch('/bookings/{booking}/status', [StaffBookingController::class, 'updateStatus'])
            ->name('bookings.update-status');
    });

Route::middleware(['auth', 'role:staff,admin,super_admin'])
    ->prefix('notifications')
    ->name('notifications.')
    ->group(function () {
        Route::patch('/{notification}/accept', [BookingNotificationController::class, 'accept'])
            ->name('accept');
    });

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/rooms', [CustomerBookingController::class, 'index'])->name('rooms.index');
        Route::post('/bookings', [CustomerBookingController::class, 'store'])->name('bookings.store');
    });

Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()?->role) {
        'super_admin' => redirect()->route('superadmin.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        'staff' => redirect()->route('staff.dashboard'),
        default => redirect()->route('customer.rooms.index'),
    };
})->name('dashboard');

Route::post('/logout', function (Request $request) {
    $role = auth()->user()?->role;

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return match ($role) {
        'super_admin' => redirect('/login/superadmin'),
        'admin' => redirect('/login/admin'),
        'staff' => redirect('/login/staff'),
        default => redirect('/login'),
    };
})->name('logout');

/*
|--------------------------------------------------------------------------
| PROFILE (OPTIONAL)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
