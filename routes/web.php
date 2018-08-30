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