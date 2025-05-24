<?php

use App\Http\Controllers\Web\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\PatientController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\Web\FeedbackController;
use App\Http\Controllers\Web\DoctorController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\StaffController;
use App\Http\Controllers\Web\LeaderController;
use App\Http\Controllers\Web\MedicalRecordController;
use App\Http\Controllers\Web\MedicineController;
use App\Http\Controllers\ReceiptExportController;

// Homepage Routes
Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/portal', [PatientController::class, 'portal'])->name('portal');
Route::post('/register', [PatientController::class, 'register'])->name('patient.register');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/queue', function () {
    return view('queue');
})->name('queue');

// Authentication Routes
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['authv3', 'role:admin'])->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('/users', UserController::class)->names('users');
    Route::post("/reset-password", [UserController::class, 'resetPassword'])->name('reset-password');
    Route::resource('/doctors', DoctorController::class)->names('doctors');
    Route::resource('/reports', ReportController::class)->names('reports');
});

// Dashboard Doctor Routes
Route::prefix('doctor')->name('doctor.')->middleware(['authv3', 'role:docter'])->group(function() {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::resource('/medicines', MedicineController::class)->names('medicines');

    // Visit routes
    Route::get('/visits', [MedicalRecordController::class, 'index'])->name('visits.index');
    Route::get('/visits/{id}/details', [MedicalRecordController::class, 'getVisitDetails'])->name('visits.details');
    // Medical Record routes
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
});

// Dashboard Staff Routes

// Dashboard Leader Routes
Route::prefix('leader')->name('leader.')->middleware(['authv3', 'role:leader'])->group(function() {
    Route::get('/dashboard', [LeaderController::class, 'dashboard'])->name('dashboard');
    // Reports
    Route::get('/reports', [LeaderController::class, 'report'])->name('reports.index');
    Route::get('/reports/{id}', [LeaderController::class, 'detailReport'])->name('reports.show');
    // Feedback routes
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('/feedbacks/{id}', [FeedbackController::class, 'show'])->name('feedbacks.show');
});

Route::prefix('staff')->name('staff.')->middleware(['authv3', 'role:staff'])->group(function() {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');

    // Patient routes
    Route::resource('/patients', PatientController::class)->except('show')->names('patients');
    Route::post('/patient/{id}/generate-mrn', [PatientController::class, 'generateMRN'])->name('patient.generate-mrn');
});
