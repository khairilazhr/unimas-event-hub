<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\RefundsController;
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
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');
        // User Management
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::get('/admin/registrations', [AdminController::class, 'registrations'])->name('admin.registrations');

        // Event Management
        Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');
        Route::post('/admin/events/{event}/approve', [AdminController::class, 'approveEvent'])->name('admin.events.approve');
        Route::post('/admin/events/{event}/reject', [AdminController::class, 'rejectEvent'])->name('admin.events.reject');
        Route::get('/admin/events/{event}', [AdminController::class, 'showEvent'])->name('admin.events.show');

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

    // User Refunds routes
    Route::get('/refunds', [App\Http\Controllers\RefundsController::class, 'index'])->name('user.refunds.index');
    Route::post('/refunds', [App\Http\Controllers\RefundsController::class, 'store'])->name('user.refunds.store');
    Route::get('/my-refunds', [RefundsController::class, 'myRefunds'])
    ->name('user.refunds.my-refunds');
});

// Forum routes
Route::middleware(['auth'])->group(function () {
    // View forum index (list of topics for an event)
    Route::get('/events/{eventId}/forum', [App\Http\Controllers\ForumController::class, 'index'])
        ->name('forum.index');

    // Create a new topic form
    Route::get('/events/{eventId}/forum/create', [App\Http\Controllers\ForumController::class, 'createTopic'])
        ->name('forum.create-topic');

    // Store a new topic
    Route::post('/events/{eventId}/forum', [App\Http\Controllers\ForumController::class, 'storeTopic'])
        ->name('forum.store-topic');

    // View a specific topic with replies
    Route::get('/events/{eventId}/forum/{topicId}', [App\Http\Controllers\ForumController::class, 'show'])
        ->name('forum.show');

    // Store a reply to a topic
    Route::post('/events/{eventId}/forum/{topicId}/reply', [App\Http\Controllers\ForumController::class, 'storeReply'])
        ->name('forum.store-reply');

    // Mark a reply as the answer
    Route::post('/events/{eventId}/forum/{topicId}/mark-answer/{replyId}', [App\Http\Controllers\ForumController::class, 'markAsAnswer'])
        ->name('forum.mark-as-answer');
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
        Route::get('/organizer/bookings/{id}', [OrganizerController::class, 'showBooking'])->name('organizer.bookings.show');

        Route::get('/organizer/refunds', [App\Http\Controllers\RefundsController::class, 'organizerRefunds'])
        ->name('organizer.refunds');
        Route::put('/organizer/refunds/{refund}', [App\Http\Controllers\RefundsController::class, 'updateRefundStatus'])
        ->name('organizer.refunds.update');
    });
});

require __DIR__.'/auth.php';
