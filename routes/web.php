<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TicketTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController; // Pastikan ini di-import

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Publik
Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');


// Grup rute yang membutuhkan autentikasi
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rute Pengguna Biasa
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ** RUTE PEMESANAN **
    Route::post('/booking/{ticketType}', [BookingController::class, 'store'])->name('booking.store');

    // ** PERBAIKAN: Rute 'user.tickets' sekarang memanggil BookingController **
    Route::get('/my-tickets', [BookingController::class, 'myTickets'])->name('user.tickets');


    // Grup Rute Admin
    Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', AdminEventController::class);
        Route::resource('events.ticket-types', TicketTypeController::class)->shallow();
        Route::get('/reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
        Route::get('/reports/sales/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export_excel');
        Route::get('/reports/sales/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export_pdf');
    });
});


// Rute otentikasi
require __DIR__.'/auth.php';
