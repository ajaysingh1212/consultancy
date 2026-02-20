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
use App\Http\Controllers\Admin\EmployerController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\InterviewController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobBoostController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\OfferLetterController;
use App\Http\Controllers\Admin\ShortlistController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use Illuminate\Support\Facades\Mail;

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
Route::middleware(['role:admin|Super Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource(
            'candidate-biometrics',
            \App\Http\Controllers\Admin\CandidateBiometricController::class
        );
});

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
        Route::get('candidate-skills',
        [\App\Http\Controllers\Admin\CandidateSkillController::class,'index']
    )->name('candidate-skills.index');

    Route::get('candidate-skills/{candidate}/edit',
        [\App\Http\Controllers\Admin\CandidateSkillController::class,'edit']
    )->name('candidate-skills.edit');

    Route::post('candidate-skills/{candidate}',
        [\App\Http\Controllers\Admin\CandidateSkillController::class,'update']
    )->name('candidate-skills.update');
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
    // candidate email verification
    Route::post('/send-otp', [App\Http\Controllers\Admin\CandidateController::class, 'sendOtp'])->name('send.otp');
    Route::post('/verify-otp', [App\Http\Controllers\Admin\CandidateController::class, 'verifyOtp'])->name('verify.otp');


    Route::prefix('wallets')->as('wallets.')->group(function () {

        Route::get('/', [WalletController::class,'index'])->name('index');
        Route::get('/{candidate}', [WalletController::class,'show'])->name('show');

        Route::post('/{wallet}/add-money',
            [WalletController::class,'addMoney'])
            ->middleware('permission:wallet.credit')
            ->name('addMoney');

        Route::post('/approve/{transaction}',
            [WalletController::class,'approve'])
            ->middleware('permission:wallet.credit')
            ->name('approve');

        Route::post('/expense/store',
            [WalletController::class,'storeExpense'])
            ->middleware('permission:wallet.debit')
            ->name('expense.store');


        Route::get('/expense/page', [WalletController::class,'expensePage'])
            ->name('expense.page');

        Route::get('/{wallet}/transactions',
        [WalletController::class, 'transactions'])
        ->name('transactions')
        ->middleware('permission:wallet.view_transactions');

        Route::get('/{wallet}/transactions/{status}',
        [WalletController::class,'filterTransactions'])
        ->name('transactions.filter')
        ->middleware('permission:wallet.view_transactions');


    });


    Route::get('wallets/expense', [WalletController::class,'expensePage'])->name('wallets.expense.page');
    Route::post('wallets/expense/store', [WalletController::class,'storeExpense'])->name('wallets.expense.store');
    Route::post('wallets/expense/approve/{id}', [WalletController::class,'approveExpense'])->name('wallets.expense.approve');
    Route::get('wallets/expense/voucher/{id}', [WalletController::class,'downloadVoucher'])->name('wallets.expense.voucher');
/* ================= EXPENSE CATEGORY ================= */

Route::prefix('expense-categories')
    ->as('expense.categories.')
    ->middleware('permission:expense.category.view')
    ->group(function () {

    Route::get('/', [ExpenseCategoryController::class,'index'])->name('index');
    Route::get('/create', [ExpenseCategoryController::class,'create'])->name('create')->middleware('permission:expense.category.create');
    Route::post('/', [ExpenseCategoryController::class,'store'])->name('store');
    Route::get('/{expenseCategory}', [ExpenseCategoryController::class,'show'])->name('show');
    Route::get('/{expenseCategory}/edit', [ExpenseCategoryController::class,'edit'])->name('edit')->middleware('permission:expense.category.edit');
    Route::put('/{expenseCategory}', [ExpenseCategoryController::class,'update'])->name('update');
    Route::delete('/{expenseCategory}', [ExpenseCategoryController::class,'destroy'])->name('destroy')->middleware('permission:expense.category.delete');
});


/* ================= EXPENSE ================= */

Route::prefix('expensecategory')
    ->as('expensecategory.')
    ->middleware('permission:expense.view')
    ->group(function () {

    Route::get('/', [ExpenseCategoryController::class,'index'])->name('index');
    Route::get('/create', [ExpenseCategoryController::class,'create'])->name('create')->middleware('permission:expense.create');
    Route::post('/', [ExpenseCategoryController::class,'store'])->name('store');
    Route::get('/{expense}', [ExpenseCategoryController::class,'show'])->name('show');
    Route::get('/{expense}/edit', [ExpenseCategoryController::class,'edit'])->name('edit');
    Route::put('/{expense}', [ExpenseCategoryController::class,'update'])->name('update');
    Route::delete('/{expense}', [ExpenseCategoryController::class,'destroy'])->name('destroy');

});
Route::prefix('expenses')
    ->as('expenses.')
    ->middleware('permission:expense.view')
    ->group(function () {

    Route::get('/', [ExpenseController::class,'index'])->name('index');
    Route::get('/create', [ExpenseController::class,'create'])->name('create')->middleware('permission:expense.create');
    Route::post('/', [ExpenseController::class,'store'])->name('store');
    Route::get('/{expense}', [ExpenseController::class,'show'])->name('show');
    Route::get('/{expense}/edit', [ExpenseController::class,'edit'])->name('edit');
    Route::put('/{expense}', [ExpenseController::class,'update'])->name('update');
    Route::delete('/{expense}', [ExpenseController::class,'destroy'])->name('destroy');

});
 // Employers
    Route::resource('employers', EmployerController::class);

    // Jobs
    Route::resource('jobs', JobController::class);
    Route::post('jobs/{job}/boost', [JobBoostController::class,'store'])
        ->name('jobs.boost');
    Route::post('jobs/{job}/feature', [JobController::class,'feature'])
        ->name('jobs.feature');

    // Applications
    Route::resource('applications', JobApplicationController::class);
    Route::get('leaderboard',
    [JobApplicationController::class,'leaderboard'])
    ->name('admin.applications.leaderboard');

    // Shortlist
    Route::post('shortlist/{application}',
        [ShortlistController::class,'store'])
        ->name('shortlist.store');

    // Interview
    Route::post('interviews',
        [InterviewController::class,'store'])
        ->name('interviews.store');

    // Offer
    Route::post('offers',
        [OfferLetterController::class,'store'])
        ->name('offers.store');

    // Skills
    Route::resource('skills', SkillController::class);
    Route::resource('interviews',
        \App\Http\Controllers\Admin\InterviewController::class);
    Route::resource('offer-letters',
        \App\Http\Controllers\Admin\OfferLetterController::class);
    // Subscription Plans
    Route::resource('plans', SubscriptionPlanController::class);
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
    Route::get('/otp-page',[App\Http\Controllers\Admin\CandidateController::class,'otpPage'])->name('otp.page');