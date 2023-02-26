<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\UserController;





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::apiResource('articles', ArticleController::class);
Route::post('articles/filter', [ArticleController::class, 'filter']);


Route::apiResource('categories', CategoryController::class);
Route::apiResource('tags', TagController::class);

Route::controller(CommentController::class)->group( function() {
    Route::get('all', 'index');
    Route::post('storecomment', 'StoreComment');
    Route::get('findcomment/{id}', 'FindComment');
    Route::delete('deletecomment/{id}', 'DeleteComment');
});



Route::post('users/register', [UserController::class, 'register']);
Route::post('users/login', [UserController::class, 'login']);







