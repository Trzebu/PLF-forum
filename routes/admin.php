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

Route::get("/admin/general_settings/system_registry/new", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@addNewRegistry",
    "as" => "admin.general_settings.system_registry.new",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/system_registry/new/post", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@addNewRegistryPost",
    "as" => "admin.general_settings.system_registry.new.post",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/system_registry/edit/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@editRegistry",
    "as" => "admin.general_settings.system_registry.edit",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/system_registry/edit/edit_value/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@editRegistryValue",
    "as" => "admin.general_settings.system_registry.edit.edit_value",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/system_registry/edit/edit_register/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@editRegistryParams",
    "as" => "admin.general_settings.system_registry.edit.edit_register",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/system_registry/edit/remove/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@removeRegistry",
    "as" => "admin.general_settings.system_registry.edit.remove",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@view",
    "as" => "admin.general_settings.manage_users",
    "middleware" => ["permissions"]
]);

/*
|--------------------------------------------------------------------------
| Users Manage
|--------------------------------------------------------------------------
|
| Here is where are located all routes to managing users.
|
*/

Route::post("/admin/general_settings/manage_users/find", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@find",
    "as" => "admin.general_settings.manage_users.find",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/view/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@viewUser",
    "as" => "admin.general_settings.manage_users.view_user",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/edit/base/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@editBase",
    "as" => "admin.general_settings.manage_users.edit.base",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/edit/new_password/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@newPassword",
    "as" => "admin.general_settings.manage_users.edit.new_password",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/manage/ban_ip/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@banIp",
    "as" => "admin.general_settings.manage_users.manage.ban_ip",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/manage/move_threads/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@moveThreads",
    "as" => "admin.general_settings.manage_users.manage.move_threads",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/manage/change_rank/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@changeRank",
    "as" => "admin.general_settings.manage_users.manage.change_rank",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/manage/add_warnings/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@addWarnings",
    "as" => "admin.general_settings.manage_users.manage.add_warnings",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/reset/warnings/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@resetWarnings",
    "as" => "admin.general_settings.manage_users.reset.warnings",
    "middleware" => ["permissions"]
]);