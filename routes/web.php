<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('mahasiswas', MahasiswaController::class);
Route::get('mahasiswas/nilai/{mahasiswa}', [MahasiswaController::class, 'nilai'])->name('mahasiswas.showNilai');


Route::get('mahasiswas/nim/{image}', function($image = null)
{
    $file = Storage::get('edit/' . $image);
    $mimetype = Storage::mimeType('edit/' . $image);
    return response($file, 100)->header('Content-Type', $mimetype);
});