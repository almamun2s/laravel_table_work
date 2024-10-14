<?php

use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('work', [WorkController::class , 'index'] )->name('work');
    Route::get('work_date_select', [WorkController::class , 'select_date'] )->name('work.date_select');
    Route::post('work_add', [WorkController::class , 'create'] )->name('work.create');
    Route::post('work_store', [WorkController::class , 'store'] )->name('work.store');
});
