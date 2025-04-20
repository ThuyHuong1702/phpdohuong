<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\Order\OrderController;
use Modules\Order\Http\Controllers\Order\OrderPrintController;
use Modules\Order\Http\Controllers\Order\OrderStatusController;

Route::group(['prefix' => 'orders'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::put('{order}/status', [OrderStatusController::class, 'update'])->name('admin.orders.status.edit');
    Route::get('{order}/print', [OrderPrintController::class, 'show'])->name('admin.orders.print.show');
    Route::get('{id}', [OrderController::class, 'show'])->name('admin.orders.show');
});

