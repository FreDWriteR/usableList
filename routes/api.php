<?php
use App\Http\Controllers\UListController;
use Illuminate\Support\Facades\Route;

Route::get('/lists', [UListController::class, 'get_u_lists']);
Route::post('/update-numbers', [UListController::class, 'updateNumbers']);
Route::delete('/lists/{id}', [UListController::class, 'deleteUList']);
