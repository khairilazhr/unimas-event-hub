<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserEventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/registration/{registration}/payment', function() {
        return redirect()->back()->with('info', 'Payment functionality will be implemented soon.');
    })->name('user.events.payment');
});

require __DIR__ . '/auth.php';