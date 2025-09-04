<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'data')->name('data.index');

Route::post('/data/export', [DataController::class, 'export']);
Route::post('/data/import', [DataController::class, 'import']);
Route::post('/data/batch-export', [DataController::class, 'batchExport']);
Route::get('/download/template/{type}', [DataController::class, 'downloadTemplate']);
