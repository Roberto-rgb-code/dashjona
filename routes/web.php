<?php

use App\Http\Controllers\DataScienceController;

Route::get('/', [DataScienceController::class,'index'])->name('dashboard');

