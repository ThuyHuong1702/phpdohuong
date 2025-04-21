<?php

use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\Media\MediaController;


Route::group([], function () {
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('admin/media/store', [MediaController::class, 'store'])->name('admin.media.store');
});
