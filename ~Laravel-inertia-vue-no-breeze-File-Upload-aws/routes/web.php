<?php

use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::inertia('/', 'Home');

Route::post('/upload',[UploadController::class, 'Upload']);