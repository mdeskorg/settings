<?php

use Illuminate\Support\Facades\Route;
use Mdeskorg\Settings\Http\Controllers\ToolController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::post('/set-info', [ToolController::class, 'setInfo']);
Route::post('/change-password', [ToolController::class, 'changePassword']);
Route::get('/', [ToolController::class, 'index']);
