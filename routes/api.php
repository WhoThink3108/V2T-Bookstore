<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\CategoryApiController;

// Gom nhóm các route API và gắn tiền tố tên 'api.' để không bị trùng với Web routes
Route::name('api.')->group(function () {
    // API cho Thể loại (Categories)
    Route::apiResource('categories', CategoryApiController::class);

    // API cho Sách (Books)
    Route::apiResource('books', BookApiController::class);
});
