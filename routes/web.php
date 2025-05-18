<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DocterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ReceiptExportController;



Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/portal', function () {
    return view('portal');
})->name('portal');

// Authentication Routes
Route::get('/login', [AuthController::class])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/queue', function () {
    return view('queue');
})->name('queue');

Route::prefix('admin')->name('admin.')->middleware(['authv3', 'role:admin'])->group(function() {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class)->names('users');
});
