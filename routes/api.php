<?php

use App\Http\Controllers\TaskController;

Route::name('api.')
    ->group(static function () {
        Route::apiResource('tasks', TaskController::class);
    });
