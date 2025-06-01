<?php

use App\Http\Controllers\Web\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\PatientController;
use App\Http\Controllers\Web\VisitController;
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
Route::get('/portal/check-medical-number', [PatientController::class, 'getExistingPatient'])->name('portal.check-medical-number');
Route::post('/register', [PatientController::class, 'register'])->name('patient.register');
Route::post('/register-existing', [PatientController::class, 'registerExistingPatientVisit'])->name('patient.register.existing');
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

// Profile Routes
Route::middleware(['authv3'])->group(function() {
    Route::get('/profile', function() {
        return view('profile');
    })->name('profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

// Dashboard Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['authv3', 'role:admin'])->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('/users', UserController::class)->names('users');
    Route::post("/reset-password", [UserController::class, 'resetPassword'])->name('reset-password');
    Route::resource('/doctors', DoctorController::class)->names('doctors');
});

// Dashboard Doctor Routes
Route::prefix('doctor')->name('doctor.')->middleware(['authv3', 'role:docter'])->group(function() {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::resource('/medicines', MedicineController::class)->names('medicines');

    // Visit routes
    Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
    Route::get('/visits/{id}/details', [VisitController::class, 'getVisitDetails'])->name('visits.details');
    Route::post('/visits/call/{id}', [VisitController::class, 'callPatient'])->name('visits.call-patient');
    // Medical Record routes
    Route::post('/check-up-patients/{id}', [VisitController::class, 'checkUpPatient'])->name('medical-records.store');
});

// Dashboard Leader Routes
Route::prefix('leader')->name('leader.')->middleware(['authv3', 'role:leader'])->group(function() {
    Route::get('/dashboard', [LeaderController::class, 'dashboard'])->name('dashboard');

    // Reports
    Route::resource('/reports', ReportController::class)->only(['index', 'show'])->names('reports');
    Route::get('/export-report/{id}', [ReportController::class, 'exportReportPDF'])->name('reports.pdf');

    // Feedback routes
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('/feedbacks/{id}', [FeedbackController::class, 'show'])->name('feedbacks.show');
});

// Dashboard Staff Routes
Route::prefix('staff')->name('staff.')->middleware(['authv3', 'role:staff'])->group(function() {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');

    // Reports routes
    Route::resource('/reports', ReportController::class)->names('reports');
    Route::get('/export-report/{id}', [ReportController::class, 'exportReportPDF'])->name('reports.pdf');

    // Patient routes
    Route::resource('/patients', PatientController::class)->only(['index', 'edit', 'update', 'destroy'])->names('patients');
    Route::post('/patient/{id}/generate-mrn', [PatientController::class, 'generateMRN'])->name('patients.generate-mrn');

    // Visit routes
    Route::resource('/visits', VisitController::class)->names('visits')->only('index');
    Route::post('/visits/{id}/generate-queue', [VisitController::class, 'validateRegisterPatient'])->name('visits.queue-number');
    Route::get('/history-visits', [VisitController::class, 'history'])->name('history-visits');
    Route::get('/visits/{id}/details', [VisitController::class, 'getVisitDetails'])->name('visits.details');
    Route::post('/visits/call/{id}', [VisitController::class, 'callPatient'])->name('visits.call-patient');

    // Medical Record routes
    Route::resource('/medical-records', MedicalRecordController::class)->names('medical-records');
    Route::get('/medical-records/{id}/details', [MedicalRecordController::class, 'getDetails'])->name('medical-records.details');
});
