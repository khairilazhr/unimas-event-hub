<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserEventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Default dashboard for all authenticated users
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin-specific routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.admin-dashboard');
        })->name('admin.dashboard');
    });

    // Organizer-specific routes
    Route::middleware(['auth', 'verified', 'role:organizer'])->group(function () {
        Route::get('/organizer/dashboard', [OrganizerController::class, 'dashboard'])
            ->name('organizer.dashboard');
    });

});

Route::middleware(['auth'])->group(function () {
    Route::get('/organizer/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/organizer/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/organizer/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/organizer/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/organizer/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/organizer/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
});

Route::get('/register/{role}', [RegisteredUserController::class, 'showRegistrationForm'])
    ->name('register.role')
    ->where('role', 'user|organizer|admin');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User event routes
    Route::get('/events', [UserEventController::class, 'index'])->name('user.events');
    Route::get('/events/{event}/register', [UserEventController::class, 'showRegistrationForm'])->name('user.events.register');
    Route::post('/events/{event}/register', [UserEventController::class, 'processRegistration'])->name('user.events.process-registration');
    Route::get('/events/registration-success/{registration}', [UserEventController::class, 'registrationSuccess'])
        ->name('user.events.registration-success');

    Route::get('/my-bookings', [UserEventController::class, 'myBookings'])->name('user.events.my-bookings');
    Route::get('/registration/{registration}', [UserEventController::class, 'registrationDetails'])->name('user.events.registration-details');
    Route::delete('/registration/{registration}/cancel', [UserEventController::class, 'cancelRegistration'])->name('user.events.cancel-registration');

    // For future implementation - placeholder route
    Route::get('/registration/{registration}/payment', function () {
        return redirect()->back()->with('info', 'Payment functionality will be implemented soon.');
    })->name('user.events.payment');

    Route::get('/verify-ticket/{id}', [App\Http\Controllers\UserEventController::class, 'verifyTicket'])
        ->name('user.events.verify-ticket');

});

Route::middleware(['auth', 'verified'])->group(function () {
    // Organizer-specific routes
    Route::middleware(['role:organizer'])->group(function () {
        Route::get('/organizer/events', [OrganizerController::class, 'myEvents'])->name('organizer.events');
        Route::get('/organizer/events/create', [OrganizerController::class, 'createEvent'])->name('organizer.create.event');
        Route::post('/organizer/events', [OrganizerController::class, 'storeEvent'])->name('organizer.store.event');
        Route::get('/events/{id}/edit', [OrganizerController::class, 'editEvent'])->name('organizer.edit.event');
        Route::patch('/events/{id}', [OrganizerController::class, 'updateEvent'])->name('organizer.update.event');
        Route::get('/organizer/events/{id}', [OrganizerController::class, 'viewEvent'])->name('organizer.view.event');
        Route::delete('/organizer/events/{id}', [OrganizerController::class, 'cancelEvent'])->name('organizer.cancel.event');
        Route::delete('/organizer/events/{id}/delete-section', [App\Http\Controllers\OrganizerController::class, 'deleteSection'])->name('organizer.delete.section');
        Route::get('/organizer/bookings', [OrganizerController::class, 'manageBookings'])->name('organizer.bookings');
        Route::post('/organizer/bookings/{id}/approve', [OrganizerController::class, 'approveBooking'])->name('organizer.approve.booking');
        Route::post('/organizer/bookings/{id}/reject', [OrganizerController::class, 'rejectBooking'])->name('organizer.reject.booking');
        Route::post('/organizer/bookings/{id}/reset', [OrganizerController::class, 'resetBooking'])->name('organizer.reset.booking');
    });
});

require __DIR__ . '/auth.php';
