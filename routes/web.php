<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login'); // Redirect to the login route
})->middleware('guest')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // Route::get('dashboard', function () {
    //     return Inertia::render('Admin/dashboard');
    // })->name('dashboard-admin');

    // Route::get('dashboard', function () {
    //     return Inertia::render('Customer/dashboard');
    // })->name('dashboard-customer');

    Route::get('dashboard', function () {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login');
        }
    
        switch ($user->role) {
            case 'admin':
                // dd('ADMIN');
                return Inertia::render('Admin/dashboard', [
                'role' => $user->role,]);
            case 'user':
                return Inertia::render('Customer/dashboard' , [
                    'role' => $user->role,]);
            // Add more roles if needed
            default:
                abort(403, 'Unauthorized role');
        }
    })->name('dashboard');

    // Route::get('/reservations',function () { 
    //     return Inertia::render('Admin/Reservations/Index');
    // })->name('reservations.index');

    // Route::get('/ticket', function(){
    //     return Inertia::render('Admin/Ticket/Index');
    // })->name('ticket.index');

    // Route::get('/calendar', function(){
    //     return Inertia::render('Admin/Calendar/Index');
    // })->name('calendar.index');

    // Route::get('/logs', function(){
    //     return Inertia::render('Admin/Logs/Index');
    // })->name('log.index');

    // Route::get('/payment', function(){
    //     return Inertia::render('Admin/Payment/Index');
    // })->name('payment.index');
    
    
    Route::middleware('role:admin')->group(function () {
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::resource('reservations', ReservationController::class)->except('index');

        Route::get('/ticket',[TicketController::class, 'index'])->name('ticket.index');
        Route::resource('ticket', TicketController::class)->except('index');
        

        Route::get('/calendar',[CalendarController::class, 'index'])->name('calendar.index'); 
        Route::resource('calendar', CalendarController::class)->except('index');
        

        Route::get('/logs',[LogController::class, 'index'])->name('log.index');
        Route::resource('logs', LogController::class)->except('index');
        

        Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index'); 
        Route::resource('payment', PaymentController::class)->except('index'); 
        
        Route::get('/user', function(){
            $role = Auth::user()->role;  
            return Inertia::render('Admin/User/Index',['role' => $role]);
        })->name('user.index');

        
    });

    
});

Route::prefix('settings')->group(function () {
    Route::get('profile', fn () => Inertia::render('Settings/Profile'));
    Route::get('password', fn () => Inertia::render('Settings/Password'));
    Route::get('appearance', fn () => Inertia::render('Settings/Appearance'));
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
