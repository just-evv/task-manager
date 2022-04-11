<?php

use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   // Log::debug('Test debug message');
    return view('index');
});

Route::get('tasks', function () {
    return view('tasks.index');
})->name('tasks');

Route::resource('task_statuses', TaskStatusController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
