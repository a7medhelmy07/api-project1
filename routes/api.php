<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\userController;
use App\Http\Controllers\API\websiteController;
use App\Http\Controllers\API\subscribeController;
use App\Http\Controllers\API\RelationShipController;

use Illuminate\Routing\RouteGroup;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

    Route::apiResource('/users' , userController::class);

    Route::apiResource('/websites' , websiteController::class);

    Route::apiResource('/posts' , postController::class);

    Route::apiResource('/subscribes' , subscribeController::class);

    Route::get('/users/{id}/websites' , [RelationShipController::class , 'userWebsites']);

    Route::get('/websites/{id}/posts' , [RelationShipController::class , 'websitePosts']);







