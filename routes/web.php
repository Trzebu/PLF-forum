<?php

use Libs\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| You can use here the middleware group.
|
*/


Route::get("/", [
    "uses" => "App\Http\Controllers\Home@index",
    "as" => "home.index"
]);

//Auth

Route::get("/login", [
    "uses" => "App\Http\Controllers\AuthController@indexLogin",
    "as" => "auth.login"
]);

Route::post("/login", [
    "uses" => "App\Http\Controllers\AuthController@postLogin",
    "as" => "auth.login"
]);

Route::get("/register", [
    "uses" => "App\Http\Controllers\AuthController@indexRegister",
    "as" => "auth.register"
]);

Route::post("/register", [
    "uses" => "App\Http\Controllers\AuthController@postRegister",
    "as" => "auth.register"
]);