<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Admin\CategoryController;

Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
Route::get('categories/{id}', [CategoryController::class, 'show'])->name('admin.categories.show');
Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
