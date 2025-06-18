<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\RefundsController;
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
        Route::get('/organizer/attendances', [OrganizerController::class, 'manageAttendances'])
            ->name('organizer.attendances');
        Route::get('/organizer/attendances/history', [OrganizerController::class, 'attendanceHistory'])
            ->name('organizer.attendances.history');

        // Questionnaire routes
        Route::prefix('organizer/questionnaires')->name('organizer.questionnaires.')->group(function () {
            Route::get('/', [QuestionnaireController::class, 'index'])->name('index');
            Route::get('/create', [QuestionnaireController::class, 'create'])->name('create');
            Route::post('/', [QuestionnaireController::class, 'store'])->name('store');
            Route::get('/{questionnaire}', [QuestionnaireController::class, 'show'])->name('show');
            Route::get('/{questionnaire}/edit', [QuestionnaireController::class, 'edit'])->name('edit');
            Route::put('/{questionnaire}', [QuestionnaireController::class, 'update'])->name('update');
            Route::delete('/{questionnaire}', [QuestionnaireController::class, 'destroy'])->name('destroy');
            Route::post('/{questionnaire}/publish', [QuestionnaireController::class, 'publish'])->name('publish');
            Route::get('/{questionnaire}/responses', [QuestionnaireController::class, 'showResponses'])->name('responses');
            Route::get('/{questionnaire}/export', [QuestionnaireController::class, 'exportResponses'])
                ->name('export');
        });
    });

});

Route::middleware(['auth'])->group(function () {
    Route::get('/organizer/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/organizer/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/organizer/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/organizer/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/organizer/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/organizer/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    Route::get('/organizer/bookings/report', [OrganizerController::class, 'bookingsReport'])->name('organizer.bookings.report');
    Route::get('/organizer/refunds/report', [App\Http\Controllers\RefundsController::class, 'refundsReport'])
        ->name('organizer.refunds.report');
    Route::get('/organizer/dashboard/report', [OrganizerController::class, 'dashboardReport'])
        ->name('organizer.dashboard.report');

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

    Route::get('/generate-ticket/{registration}', [UserEventController::class, 'generateTicket'])
        ->name('user.events.generate-ticket');

    Route::post('/mark-attendance/{registration}', [OrganizerController::class, 'markAttendance'])
        ->name('organizer.mark-attendance');

    // For future implementation - placeholder route
    Route::get('/registration/{registration}/payment', function () {
        return redirect()->back()->with('info', 'Payment functionality will be implemented soon.');
    })->name('user.events.payment');

    Route::get('/verify-ticket/{registration}', [UserEventController::class, 'verifyTicket'])
        ->name('user.events.verify-ticket');

    // User Refunds routes
    Route::get('/refunds', [App\Http\Controllers\RefundsController::class, 'index'])->name('user.refunds.index');
    Route::post('/refunds', [App\Http\Controllers\RefundsController::class, 'store'])->name('user.refunds.store');
    Route::get('/my-refunds', [RefundsController::class, 'myRefunds'])
        ->name('user.refunds.my-refunds');

    // My Attendances route
    Route::get('/my-attendances', [UserEventController::class, 'myAttendances'])
        ->name('user.events.my-attendances');

    // Questionnaire response routes
    Route::get('/events/{event}/questionnaires', [QuestionnaireController::class, 'userQuestionnaires'])
        ->name('user.questionnaires.index');
    Route::get('/questionnaires/{questionnaire}/respond', [QuestionnaireController::class, 'showResponseForm'])
        ->name('user.questionnaires.respond');
    Route::post('/questionnaires/{questionnaire}/respond', [QuestionnaireController::class, 'storeResponse'])
        ->name('user.questionnaires.store-response');
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

// Add this temporary debug route to verify the route is working
Route::get('/debug/routes', function () {
    dd(Route::getRoutes()->getRoutesByName());
});

// Temporary debug route for questionnaire update
Route::get('/debug/questionnaire-update/{questionnaire}', function ($questionnaire) {
    $questionnaire = App\Models\Questionnaire::findOrFail($questionnaire);
    return response()->json([
        'questionnaire' => $questionnaire,
        'questions'     => $questionnaire->questions,
        'route'         => route('organizer.questionnaires.update', $questionnaire),
    ]);
})->name('debug.questionnaire.update');

// Temporary test route for form submission debugging
Route::post('/debug/form-test', function (Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info('Form test received:', $request->all());
    return response()->json(['message' => 'Form received', 'data' => $request->all()]);
})->name('debug.form.test');

// Temporary route to test questionnaire update with any method
Route::match(['GET', 'POST', 'PUT', 'PATCH'], '/debug/questionnaire-update-test/{questionnaire}', function (Illuminate\Http\Request $request, $questionnaire) {
    \Illuminate\Support\Facades\Log::info('Questionnaire update test received');
    \Illuminate\Support\Facades\Log::info('Method: ' . $request->method());
    \Illuminate\Support\Facades\Log::info('URL: ' . $request->url());
    \Illuminate\Support\Facades\Log::info('Data: ', $request->all());
    return response()->json(['message' => 'Update test received', 'method' => $request->method(), 'data' => $request->all()]);
})->name('debug.questionnaire.update.test');

require __DIR__ . '/auth.php';
