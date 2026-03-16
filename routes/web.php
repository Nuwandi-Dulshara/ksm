<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\OutcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ApprovalHistoryController;
use App\Http\Controllers\CategorySummaryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', function () {
    abort(404);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Income
    |--------------------------------------------------------------------------
    */

    Route::resource('income', IncomeController::class);

    /*
    |--------------------------------------------------------------------------
    | Outcomes
    |--------------------------------------------------------------------------
    */

    Route::resource('outcomes', OutcomeController::class);

    // ✅ AJAX - Get Categories by Expense Type
    Route::get('/get-categories/{expenseType}',
        [OutcomeController::class, 'getCategories'])
        ->name('outcomes.getCategories');

    // ✅ Approve Outcome
    Route::post('/outcomes/{id}/approve',
        [OutcomeController::class, 'approve'])
        ->name('outcomes.approve');

    // ✅ Reject Outcome
    Route::post('/outcomes/{id}/reject',
        [OutcomeController::class, 'reject'])
        ->name('outcomes.reject');

    // Serve the view located at resources/views/outcome-report/index.blade.php
    // Use controller so we can provide backend data and accept filters
    Route::get('/outcome-report', [\App\Http\Controllers\OutcomeReportController::class, 'index'])
        ->name('outcome-report.index');

    Route::get('/approval-history', [ApprovalHistoryController::class, 'index'])
        ->name('approval.history');

    Route::get('/category-summary', [CategorySummaryController::class, 'index'])
        ->name('category.summary');

    /*
    |--------------------------------------------------------------------------
    | Employees
    |--------------------------------------------------------------------------
    */

    Route::resource('employees', EmployeeController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::view('/monthly-salary', 'monthly-salary')
        ->name('monthly.salary');

    Route::view('/approve-salary', 'approve-salary')
        ->name('approve.salary');

    /*
    |--------------------------------------------------------------------------
    | Other Pages
    |--------------------------------------------------------------------------
    */

    Route::view('/freelancers', 'people-list')
        ->name('freelancers');

    Route::view('/social-media', 'social-media')
        ->name('social.media');

    Route::view('/beneficiary', 'add-beneficiary')
        ->name('beneficiary');

    Route::view('/settings', 'settings')
        ->name('settings');

    Route::view('/outcome-receipt', 'outcome-receipt')
        ->name('outcome.receipt');

    /*
    |--------------------------------------------------------------------------
    | Management
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('donators', \App\Http\Controllers\DonatorController::class);
    Route::resource('expense-types', ExpenseTypeController::class);
    Route::resource('expense-categories', ExpenseCategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__.'/auth.php';
