<?php

use App\Http\Controllers\Orgs\ChecklistController;
use App\Http\Controllers\Orgs\ContractController;
use App\Http\Controllers\Orgs\CustomerController;
use App\Http\Controllers\Orgs\EventsController;
use App\Http\Controllers\Orgs\EventTypeController;
use App\Http\Controllers\Orgs\FinancialController;
use App\Http\Controllers\Orgs\ItemCategoryController;
use App\Http\Controllers\Orgs\ItemController;
use App\Http\Controllers\Orgs\MemberController;
use App\Http\Controllers\Orgs\OrganizationController;
use App\Http\Controllers\Orgs\PayableController;
use App\Http\Controllers\Orgs\ProposalController;
use App\Http\Controllers\Orgs\ReceivablesController;
use App\Http\Controllers\Orgs\SupplierController;
use App\Http\Controllers\Orgs\TodoCardController;
use App\Http\Controllers\Orgs\TodoCardPaymentController;
use App\Http\Controllers\Orgs\TodoCardTaskController;
use App\Http\Controllers\Users\InviteController;
use App\Http\Controllers\Users\MeController;
use Illuminate\Support\Facades\Route;

require __DIR__ . "/auth.php";

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/me', [MeController::class, 'index']);
    Route::get('/users/invites', [InviteController::class, 'index']);

    Route::get('/orgs', [OrganizationController::class, 'index']);
    Route::post('/orgs', [OrganizationController::class, 'store']);

    Route::middleware('check.organization')->prefix('/orgs/{org}')->group(function () {
        Route::apiResource('/customers', CustomerController::class);
        Route::apiResource('/items/categories', ItemCategoryController::class);
        Route::apiResource('/items', ItemController::class);
        Route::apiResource('/event-types', EventTypeController::class);
        Route::apiResource('/suppliers', SupplierController::class);
        Route::apiResource('/members', MemberController::class);

        Route::get('/checklist', [ChecklistController::class, 'index']);

        Route::prefix('/todos')->group(function () {
            Route::get('/', [TodoCardController::class, 'index']);
            Route::get('/{todo}', [TodoCardController::class, 'show']);
            Route::patch('/{todo}', [TodoCardController::class, 'update']);
            Route::patch('/{todo}/owner', [TodoCardController::class, 'owner']);
            Route::patch('/{todo}/supplier', [TodoCardController::class, 'supplier']);
            Route::apiResource('/{todo}/tasks', TodoCardTaskController::class);
            Route::apiResource('/{todo}/payments', TodoCardPaymentController::class);
        });

        Route::get('/proposals/{proposal}/versions', [ProposalController::class, 'versions']);
        Route::post('/proposals/{proposal}/{version}/contract', [ContractController::class, 'store']);

        Route::apiResource('/proposals', ProposalController::class);

        Route::apiResource('/calendar', EventsController::class);

        Route::prefix('/financial')->group(function () {
            Route::apiResource('', FinancialController::class);
            Route::get('/events', [FinancialController::class, 'events']);
            });

        Route::apiResource('/payables', PayableController::class);

        Route::apiResource('/receivables', ReceivablesController::class);
    });
});
