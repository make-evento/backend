<?php

use App\Http\Controllers\Auth\AccessCodeController;
use App\Http\Controllers\Auth\CreateAccountController;
use Illuminate\Support\Facades\Route;

Route::prefix("auth")->group(function () {
    Route::post("access-code", [AccessCodeController::class, "send"])
        ->middleware(["guest", "throttle:6,1"])
        ->name("access-code.send");

    Route::post("access-code/validate", [AccessCodeController::class, "verify"])
        ->middleware("guest", "throttle:6,1")
        ->name("access-code.verify");

    Route::post("sign-up", [CreateAccountController::class, "store"])
        ->middleware(["guest", "throttle:6,1"]);
});
