<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Public routes
Route::get('/', function () {
    return view('index');
})->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard route (determines redirect based on role)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// User routes (for regular users - read only access)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/rankings', [UserController::class, 'rankings'])->name('rankings');
    Route::get('/comparison', [UserController::class, 'comparison'])->name('comparison');
    Route::get('/detail/{alternative}', [UserController::class, 'detail'])->name('detail');
});

// Admin routes (SMART DSS - Admin only)
Route::middleware(['auth', 'admin'])->prefix('smart')->name('smart.')->group(function () {
    Route::get('/', [SmartController::class, 'index'])->name('index');
    Route::post('/calculate', [SmartController::class, 'calculate'])->name('calculate');
    Route::get('/rankings', [SmartController::class, 'rankings'])->name('rankings');
    Route::get('/detail/{alternative}', [SmartController::class, 'detail'])->name('detail');
    Route::get('/comparison', [SmartController::class, 'comparison'])->name('comparison');
    
    // Management routes
    Route::get('/criteria', [SmartController::class, 'criteriaManagement'])->name('criteria');
    Route::put('/criteria/weights', [SmartController::class, 'updateCriteriaWeights'])->name('criteria.weights.update');
    
    // Alternative CRUD routes
    Route::get('/alternatives', [SmartController::class, 'alternativeManagement'])->name('alternatives');
    Route::get('/alternatives/create', [SmartController::class, 'createAlternative'])->name('alternatives.create');
    Route::post('/alternatives', [SmartController::class, 'storeAlternative'])->name('alternatives.store');
    Route::get('/alternatives/{id}', [SmartController::class, 'showAlternative'])->name('alternatives.show');
    Route::get('/alternatives/{id}/edit', [SmartController::class, 'editAlternative'])->name('alternatives.edit');
    Route::put('/alternatives/{id}', [SmartController::class, 'updateAlternative'])->name('alternatives.update');
    Route::delete('/alternatives/{id}', [SmartController::class, 'destroyAlternative'])->name('alternatives.destroy');
    
    // API routes
Route::get('/api/rankings', [SmartController::class, 'apiRankings'])->name('api.rankings');
});




