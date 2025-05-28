<?php

use Illuminate\Support\Facades\Route;

// Guest Controllers
use App\Http\Controllers\GuestEventController;
use App\Http\Controllers\HomeController; // Jika Anda punya HomeController terpisah

// Authenticated User Controllers (Umum)
use App\Http\Controllers\DashboardController; // Controller untuk dashboard umum setelah login
use App\Http\Controllers\ProfileController;

// Member Controllers
use App\Http\Controllers\Member\EventRegistrationController; // Contoh namespace untuk Member
use App\Http\Controllers\Member\MyEventController as MemberMyEventController;

// Administrator Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\EventController as AdminEventController; // Jika admin juga mengelola event

// Finance Team Controllers
use App\Http\Controllers\Finance\PaymentVerificationController;
use App\Http\Controllers\Finance\DashboardController as FinanceDashboardController;

// Committee Controllers
use App\Http\Controllers\Committee\EventController as CommitteeEventController;
use App\Http\Controllers\Committee\AttendanceController as CommitteeAttendanceController;
use App\Http\Controllers\Committee\CertificateController as CommitteeCertificateController;
use App\Http\Controllers\Committee\DashboardController as CommitteeDashboardController;


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

// Guest Routes
Route::get('/', [GuestEventController::class, 'index'])->name('home'); // Atau HomeController
Route::get('/events', [GuestEventController::class, 'index'])->name('guest.events.index');
Route::get('/events/{event}', [GuestEventController::class, 'show'])->name('guest.events.show');


// Laravel Breeze Authentication Routes (biasanya sudah ada jika Anda menjalankan breeze:install)
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Akan kita override di bawah dengan controller

require __DIR__.'/auth.php'; // Ini memuat rute login, register, forgot password, dll. dari Breeze


// Authenticated Routes (Semua pengguna yang sudah login dan terverifikasi)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Umum (bisa diakses semua peran setelah login)
    // Pastikan DashboardController ada dan memiliki metode index
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Member Specific Routes
    Route::prefix('member')->name('member.')->middleware(['role:member'])->group(function () {
        Route::get('/my-events', [MemberMyEventController::class, 'index'])->name('my-events.index'); // Melihat event yang diikuti
        Route::get('/events/{event}/register', [EventRegistrationController::class, 'create'])->name('events.register.create');
        Route::post('/events/{event}/register', [EventRegistrationController::class, 'store'])->name('events.register.store');
        Route::get('/my-registrations', [EventRegistrationController::class, 'myRegistrations'])->name('registrations.index');
        Route::get('/my-registrations/{registration}/payment', [EventRegistrationController::class, 'editPayment'])->name('registrations.payment.edit');
        Route::put('/my-registrations/{registration}/payment', [EventRegistrationController::class, 'updatePayment'])->name('registrations.payment.update');
        // Tambahkan rute lain untuk member jika ada
    });

    // Administrator Specific Routes
    Route::prefix('admin')->name('admin.')->middleware(['role:administrator'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard'); // Dashboard khusus Admin
        Route::resource('/users', AdminUserController::class); // CRUD Pengguna
        Route::resource('/roles', AdminRoleController::class)->except(['show']); // CRUD Peran (jika diperlukan)
        Route::resource('/events', AdminEventController::class)->except(['show']); // Jika Admin bisa mengelola semua event
        // Tambahkan rute lain untuk administrator
    });

    // Finance Team Specific Routes
    Route::prefix('finance')->name('finance.')->middleware(['role:tim-keuangan'])->group(function () {
        Route::get('/dashboard', [FinanceDashboardController::class, 'index'])->name('dashboard'); // Dashboard khusus Tim Keuangan
        Route::get('/verifications', [PaymentVerificationController::class, 'index'])->name('verifications.index');
        Route::get('/verifications/{registration}', [PaymentVerificationController::class, 'show'])->name('verifications.show');
        Route::post('/verifications/{registration}/approve', [PaymentVerificationController::class, 'approve'])->name('verifications.approve');
        Route::post('/verifications/{registration}/reject', [PaymentVerificationController::class, 'reject'])->name('verifications.reject');
        // Tambahkan rute lain untuk tim keuangan
    });

    // Committee Specific Routes
    Route::prefix('committee')->name('committee.')->middleware(['role:panitia'])->group(function () {
        Route::get('/dashboard', [CommitteeDashboardController::class, 'index'])->name('dashboard'); // Dashboard khusus Panitia
        Route::resource('/events', CommitteeEventController::class); // CRUD Event oleh Panitia

        Route::get('/events/{event}/attendance/scan', [CommitteeAttendanceController::class, 'scanPage'])->name('attendance.scan.page');
        Route::post('/attendance/mark', [CommitteeAttendanceController::class, 'markAttendance'])->name('attendance.mark');

        Route::get('/events/{event}/certificates', [CommitteeCertificateController::class, 'indexForEvent'])->name('certificates.indexForEvent');
        Route::get('/registrations/{registration}/certificate/create', [CommitteeCertificateController::class, 'create'])->name('certificates.create');
        Route::post('/registrations/{registration}/certificate', [CommitteeCertificateController::class, 'store'])->name('certificates.store');
        Route::get('/certificates/{certificate}/edit', [CommitteeCertificateController::class, 'edit'])->name('certificates.edit');
        Route::put('/certificates/{certificate}', [CommitteeCertificateController::class, 'update'])->name('certificates.update');
        // Tambahkan rute lain untuk panitia
    });
});
