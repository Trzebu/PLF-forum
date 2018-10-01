<?php

use Libs\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
| You can use here the middleware group.
|
*/

Route::get("/admin", [
    "uses" => "App\Http\Controllers\AdminControllers\GeneralController@generalView",
    "as" => "admin.index",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings", [
    "uses" => "App\Http\Controllers\AdminControllers\GeneralController@generalView",
    "as" => "admin.general_settings",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/system_registry", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@view",
    "as" => "admin.general_settings.system_registry",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/php_info", [
    "uses" => "App\Http\Controllers\AdminControllers\GeneralController@phpInfo",
    "as" => "admin.general_settings.php_info",
    "middleware" => ["permissions"]
]);