<?php

use App\Models\StaffProvinces;
use App\Models\User;
use App\Models\Report;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ResponseProgressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\StaffProvincesController;
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
    return view('utama');
});

Route::get('/login', [UserController::class, 'index'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/login', [UserController::class, 'loginRegister'])->name('login.register');
Route::get('/user', [UserController::class, 'index'])->name('utama');
Route::get('/chart', [ChartController::class, 'index'])->name('chart');

Route::get('/response', [ResponseController::class, 'index'])->name('response');
Route::get('/response/detail/{id}', [ResponseController::class, 'show'])->name('response.show');
Route::post('/response/store/{id}', [ResponseController::class, 'store'])->name('response.status');
Route::patch('/response/update/{id}', [ResponseController::class, 'update'])->name('response.update.status');
Route::post('/response/progres/{id}', [ResponseProgressController::class, 'store'])->name('response.progress');
Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');

Route::prefix('/reports')->name('reports.')->group(function () {
    Route::post('vote/{report_id}', [ReportController::class, 'vote'])->name('vote');
    Route::get('/article', [ReportController::class, 'article'])->name('article');
    Route::post('/reports/{id}/view', [ReportController::class, 'TambahView'])->name('viewers');
    Route::get('/create', [ReportController::class, 'create'])->name('create')->middleware('auth');
    Route::post('/reports', [ReportController::class, 'store'])->name('store')->middleware('auth');
    Route::get('/index/{id}', [ReportController::class, 'index'])->name('index');
    Route::get('/me', [ReportController::class, 'detail'])->name('detail');
    Route::post('/comments', [ReportController::class, 'comment'])->name('comment');
    Route::get('/search', [ReportController::class, 'search'])->name('search');
    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('destroy');

});

Route::prefix('/staffprovinces')->name('staffprovinces.')->group(function () {
    Route::get('/reset/{id}', [StaffProvincesController::class, 'resetPassword'])->name('reset');
    Route::get('/kelola' , [StaffProvincesController::class, 'kelola'])->name('kelola');
    Route::get('/chart', [StaffProvincesController::class, 'dashboard'])->name('chart');
    Route::post('/store' , [StaffProvincesController::class, 'store'])->name('store');
    Route::delete('/delete/{id}', [StaffProvincesController::class, 'delete'])->name('delete');
});

