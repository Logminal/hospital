<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorScheduleController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('main');
})->name("main");

Route::get('/auth', function () {
    return view('auth_form');
})->name('auth');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Doctor appointments (должно быть перед /doctor/{doctor} чтобы избежать конфликта)
Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/appointments', [DoctorAppointmentController::class, 'index'])->name('doctor.appointments.index');
    Route::post('/doctor/appointments/{appointment}/status', [DoctorAppointmentController::class, 'updateStatus'])->name('doctor.appointments.status')->where('appointment', '[0-9]+');
    Route::post('/doctor/appointments/{appointment}/complete', [DoctorAppointmentController::class, 'completeAppointment'])->name('doctor.appointments.complete')->where('appointment', '[0-9]+');
    Route::post('/doctor/appointments/{appointment}/cancel', [DoctorAppointmentController::class, 'cancelAppointment'])->name('doctor.appointments.cancel')->where('appointment', '[0-9]+');
    
    // Управление расписанием врача
    Route::get('/doctor/schedule', [DoctorScheduleController::class, 'index'])->name('doctor.schedule.index');
    Route::post('/doctor/schedule', [DoctorScheduleController::class, 'store'])->name('doctor.schedule.store');
    Route::put('/doctor/schedule/{id}', [DoctorScheduleController::class, 'update'])->name('doctor.schedule.update')->where('id', '[0-9]+');
    Route::delete('/doctor/schedule/{id}', [DoctorScheduleController::class, 'destroy'])->name('doctor.schedule.destroy')->where('id', '[0-9]+');
});

// Appointments (Client side)
Route::get('/doctors', [AppointmentController::class, 'index'])->name('doctors.index');
Route::get('/doctor/{doctor}', [AppointmentController::class, 'show'])->name('doctor.show');
Route::post('/appointments/check-availability', [AppointmentController::class, 'checkAvailability'])->name('appointments.check');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.my');
Route::middleware(['auth'])->group(function () {
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancelAppointment'])->name('appointments.cancel')->where('id', '[0-9]+');
});

// Admin (только для администраторов)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'adminPanel'])->name('adminPanel');
    Route::post("/admin/store/specialty", [AdminController::class, 'storeSpecialty'])->name('store.specialty');
    Route::post("/admin/store/doctor", [AdminController::class, 'storeDoctor'])->name('store.doctor');
    Route::post("/admin/store/admin", [AdminController::class, 'storeAdmin'])->name('store.admin');
    Route::get("/admin/doctor/{id}", [AdminController::class, 'showDoctor'])->name('show.doctor');
    Route::delete("/admin/doctor/{id}", [AdminController::class, 'destroyDoctor'])->name('destroy.doctor');
    Route::get("/admin/user/{id}", [AdminController::class, 'showUser'])->name('show.user');
    Route::delete("/admin/user/{id}", [AdminController::class, 'destroyUser'])->name('destroy.user');
    Route::delete("/admin/specialty/{id}", [AdminController::class, 'destroySpecialty'])->name('destroy.specialty');
});
