<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\WebController;
use App\Http\Controllers\ProfileController;

/* ================= ADMIN CONTROLLERS ================= */
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\CandidateKycController;
use App\Http\Controllers\Admin\CandidateVerificationController;
use App\Http\Controllers\Admin\WalletController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [WebController::class, 'index'])->name('default');
Route::redirect('/login', '/login');

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Redirect After Login
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin'],
], function () {

    /* ================= Dashboard ================= */
    Route::get('/', [HomeController::class, 'index'])
        ->name('dashboard');

    /* ================= Users ================= */
    Route::resource('users', UserController::class)
        ->middleware('permission:user.view');

    /* ================= Roles ================= */
    Route::resource('roles', RoleController::class)
        ->middleware('permission:role.view');

    /* ================= Permissions ================= */
    Route::delete('permissions/destroy',
        [PermissionController::class, 'massDestroy'])
        ->middleware('permission:permission.delete')
        ->name('permissions.massDestroy');

    Route::post('permissions/parse-csv-import',
        [PermissionController::class, 'parseCsvImport'])
        ->middleware('permission:permission.create')
        ->name('permissions.parseCsvImport');

    Route::post('permissions/process-csv-import',
        [PermissionController::class, 'processCsvImport'])
        ->middleware('permission:permission.create')
        ->name('permissions.processCsvImport');

    Route::resource('permissions', PermissionController::class)
        ->middleware('permission:permission.view');

    /* =====================================================
    | Candidates Module
    ====================================================== */

    /* ===== Candidate CRUD ===== */
    Route::resource('candidates', CandidateController::class)
        ->middleware('permission:candidate.view');

    /* ===== Candidate KYC (OPEN FORM) ===== */
    Route::get(
        'candidates/{candidate}/kyc',
        [CandidateKycController::class, 'show']
    )->name('candidates.kyc.show')
     ->middleware('permission:candidate.verify');

    /* ===== Candidate KYC (STORE FORM DATA) ===== */
    Route::post(
        'candidates/{candidate}/kyc',
        [CandidateKycController::class, 'store']
    )->name('candidates.kyc.store')
     ->middleware('permission:candidate.verify');

    /* ===== Candidate Documents (OPEN PAGE) ===== */
    Route::get(
        'candidates/{candidate}/documents',
        [CandidateController::class, 'documents']
    )->name('candidates.documents')
     ->middleware('permission:candidate.verify');

    /* ===== Candidate Documents (UPLOAD STORE) ===== */
    Route::post(
        'candidates/{candidate}/documents',
        [CandidateController::class, 'storeDocuments']
    )->name('candidates.documents.store')
     ->middleware('permission:candidate.verify');

    /* ===== Verification Dashboard ===== */
    Route::get(
        'candidate-verification',
        [CandidateVerificationController::class, 'index']
    )->name('candidate.verification.index')
     ->middleware('permission:candidate.verify');

    /* ===== Verify Candidate Document ===== */
    Route::post(
        'candidate-document/{document}/verify',
        [CandidateVerificationController::class, 'verify']
    )->name('candidate.document.verify')
     ->middleware('permission:candidate.verify');

    /* ===== Verify Candidate Education ===== */
    Route::post(
        'candidate-education/{education}/verify',
        [CandidateVerificationController::class, 'verifyEducation']
    )->name('candidate.education.verify')
     ->middleware('permission:candidate.verify');
    /* ===== Candidate Master Profile ===== */
    Route::get('candidates/{candidate}/profile',
        [CandidateController::class,'profile'])
        ->name('candidates.profile')
        ->middleware('permission:candidate.view');
    Route::post('candidates/{candidate}/verify-address',
    [CandidateVerificationController::class,'verifyAddress'])
    ->name('candidates.verify.address')
    ->middleware('role:admin|super-admin');

    Route::post('candidates/{candidate}/verify-education',
        [CandidateVerificationController::class,'verifyEducation'])
        ->name('candidates.verify.education')
        ->middleware('role:admin|super-admin');

    Route::post('candidates/{candidate}/verify-documents',
        [CandidateVerificationController::class,'verifyDocuments'])
        ->name('candidates.verify.documents')
        ->middleware('role:admin|super-admin');

    Route::get('history/{type}/{id}',
    [CandidateVerificationController::class,'history']);

    Route::post('bulk-approve/{type}/{candidate}',
    [CandidateVerificationController::class,'bulkApprove'])
    ->name('bulk.approve');
    Route::post(
    'address/{address}/update-status',
    [CandidateVerificationController::class,'updateAddressStatus']
    )->name('address.update.status')
    ->middleware('role:admin|Super Admin');

    Route::post(
        'education/{education}/update-status',
        [CandidateVerificationController::class,'updateEducationStatus']
    )->name('education.update.status')
    ->middleware('role:admin|Super Admin');

    Route::post(
        'document/{document}/update-status',
        [CandidateVerificationController::class,'updateDocumentStatus']
    )->name('document.update.status')
    ->middleware('role:admin|Super Admin');


Route::prefix('wallets')->as('wallets.')->group(function () {

    // All wallets
    Route::get('/', [WalletController::class, 'index'])
        ->name('index');

    // Specific wallet
    Route::get('/{candidate}', [WalletController::class, 'show'])
        ->name('show');

    Route::post('/{wallet}/transaction', [WalletController::class, 'transaction'])
        ->name('transaction');
        
    Route::post('/wallets/{wallet}/transaction', [WalletController::class, 'transaction'])
    ->name('wallets.transaction');

});


});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
