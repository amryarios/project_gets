<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DataJemaatController;

Route::middleware(['auth'])->group(function () {

    // Menu User Management
    Route::get('/users', [UserController::class, 'index'])->middleware('checkPermission:view_users');
    Route::post('/users', [UserController::class, 'store'])->middleware('checkPermission:add_users');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->middleware('checkPermission:edit_users');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('checkPermission:delete_users');

    // Menu Data Jemaat
    Route::get('/jemaat', [DataJemaatController::class, 'index'])->middleware('checkPermission:view_jemaat');
    Route::post('/jemaat', [DataJemaatController::class, 'store'])->middleware('checkPermission:add_jemaat');
    Route::get('/jemaat/{id}/edit', [DataJemaatController::class, 'edit'])->middleware('checkPermission:edit_jemaat');
    Route::delete('/jemaat/{id}', [DataJemaatController::class, 'destroy'])->middleware('checkPermission:delete_jemaat');
});

