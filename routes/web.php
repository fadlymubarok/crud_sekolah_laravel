<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JurusanController;

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
    return view('welcome');
});


Route::get('/dashboard', function () {
    $title = 'dashboard';
    return view('dashboard', compact('title'));
})->middleware('auth')->name('dashboard');

Route::resource('siswa', SiswaController::class)->middleware('is_not_admin');
Route::middleware(['is_admin'])->group(function () {
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('jurusan', JurusanController::class);
});
require __DIR__ . '/auth.php';
