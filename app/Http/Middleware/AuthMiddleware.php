<?php

/*
|--------------------------------------------------------------------------
| Middleware groups: Auth
|--------------------------------------------------------------------------
|
| Here is detected that user is logged.
|
*/

namespace App\Http\Middleware;
use Libs\User;
use Libs\Http\Redirect;
use Libs\Http\Response;

class AuthMiddleware {

    public function __construct () {
        if (!User::check()) {
            Redirect::to("home.index");
            exit();
        }
    }

}