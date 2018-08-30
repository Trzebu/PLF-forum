<?php

/*
|--------------------------------------------------------------------------
| Middleware groups
|--------------------------------------------------------------------------
|
| Here is where you can register new middleware groups for your application.
|
*/

return [
    "guest" => "App\Http\Middleware\GuestMiddleware",
    "auth" => "App\Http\Middleware\AuthMiddleware",
    "permissions" => "App\Http\Middleware\PermissionsMiddleware",
];