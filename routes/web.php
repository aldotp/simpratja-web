<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DocterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;



Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/portal', function () {
    return view('portal');
})->name('portal');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/queue', function () {
    return view('queue');
})->name('queue');

Route::prefix('admin')->group(function() {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users');
    Route::get('/users/create', function () {
        return view('admin.users.create');
    })->name('create');
})->name('admin');


Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post("/login", [AuthController::class, 'loginv3']);
        Route::group(['middleware' => ['authv3']], function() {
            Route::get("/profile", [AuthController::class, 'profilev3']);
            Route::delete("/logout", [AuthController::class, 'logout']);
        });
    });

    // Endpoint Admin
    Route::prefix('admin')->middleware(['authv3', 'role:admin'])->group(function () {
        Route::post('/users', [UserController::class, 'createUser']);
        Route::get('/users', [UserController::class, 'getAllUsers']);
        Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
        Route::put('/users/{id}', [UserController::class, 'updateUser']);
        Route::get('/users/{id}', [UserController::class, 'getUser']);
        Route::put('/users/{id}/reset-password', [UserController::class, 'resetPassword']);

        Route::get('/docters', [DocterController::class, 'index']);
        Route::post('/docters', [DocterController::class, 'store']);
        Route::put('/docters/{id}', [DocterController::class, 'update']);
        Route::get('/docters/{id}', [DocterController::class, 'show']);
        Route::delete('/docters/{id}', [DocterController::class, 'delete']);

        Route::get('/reports', [ReportController::class, 'index']);
        Route::post('/reports', [ReportController::class, 'store']);
        Route::put('/reports/{id}', [ReportController::class, 'update']);
        Route::get('/reports/{id}', [ReportController::class, 'show']);
    });


    // Endpoint Patients
    Route::prefix('patients')->group(function () {
        Route::post('/register', [PatientController::class, 'register']);
        Route::post('/register-existing', [VisitController::class, 'registerExistingPatientVisit']);
        Route::get('/registrations/', [PatientController::class, 'getAllRegistration']);
        Route::get('/registrations/{id}', [PatientController::class, 'showRegistration']);
        Route::get('/queue-number/{id}', [VisitController::class, 'getQueueNumber']);
        Route::post('/feedbacks', [FeedbackController::class, 'store']);

        Route::get('/', [PatientController::class, 'index']);
        Route::put('/{id}', [PatientController::class, 'update']);

        Route::get('/feedbacks', [FeedbackController::class, 'index']);
        Route::get('/feedbacks/{id}', [FeedbackController::class, 'show']);
    });

    // Endpoint Doctor
    Route::prefix('docters')->middleware(['authv3', 'role:docter'])->group(function () {
        Route::get('/visits', [VisitController::class, 'getAllVisits']);
        Route::get('/visits/{id}', [VisitController::class, 'getVisitByID']);
        Route::get('/medical-records/{id}', [MedicalRecordController::class, 'getMedicalRecordDetailByPatientID']);
        Route::post('/medical-records', [MedicalRecordController::class, 'createMedicalRecord']);
        Route::get('/medical-records', [MedicalRecordController::class, 'getAllMedicalRecord']);

        Route::get('/patients', [PatientController::class, 'index']);
        Route::get('/patients/{id}', [PatientController::class, 'showRegistration']);

        Route::get('/visits', [VisitController::class, 'getAllVisits']);
        Route::get('/visits/{id}', [VisitController::class, 'getVisitByID']);

        Route::get('/medicines', [MedicineController::class, 'index']);
        Route::get('/medicines/{id}', [MedicineController::class, 'show']);
        Route::post('/medicines', [MedicineController::class, 'store']);
        Route::put('/medicines/{id}', [MedicineController::class, 'update']);
        Route::delete('/medicines/{id}', [MedicineController::class, 'destroy']);

        Route::get('/dashboard/counts', [DocterController::class, 'getPatientCountByDocterID']); // tambahkan ini
    });

    // Endpoint Staff
    Route::prefix('staff')->middleware(['authv3', 'role:staff'])->group(function () {
        Route::get('/patients', [PatientController::class, 'index']); // lihat data pasien
        Route::get('/patients/{id}', [PatientController::class, 'showRegistration']);
        Route::put('/patients/{id}', [PatientController::class, 'update']); // update data pasien
        Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

        Route::get('/medical-records', [MedicalRecordController::class, 'getAllMedicalRecord']); // tambahkan ini
        Route::get('/medical-records/{id}', [MedicalRecordController::class, 'getMedicalRecordDetailByPatientID']); // detail rekam medis
        Route::get('/dashboard/counts', [StaffController::class, 'getCounts']); // tambahkan ini


        Route::get('/feedbacks', [FeedbackController::class, 'index']);
        Route::get('/feedbacks/{id}', [FeedbackController::class, 'show']);

        Route::post('/visits/validate/{id}', [VisitController::class, 'validateVisits']); // validasi kunjungan
        Route::get('/visits', [VisitController::class, 'getAllVisits']);
        Route::get('/visits/{id}', [VisitController::class, 'getVisitByID']);
        Route::get('/medicines', [MedicineController::class, 'index']);
    });

    // Endpoint Leaders
    Route::prefix('leader')->middleware(['authv2', 'role:leader'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/feedbacks', [FeedbackController::class, 'index']);
        Route::get('/feedbacks/{id}', [FeedbackController::class, 'show']);
        Route::get('/dashboard/count', [LeaderController::class, 'getCounts']);
    });
});
