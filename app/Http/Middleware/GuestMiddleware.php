<?php

/*
|--------------------------------------------------------------------------
| Middleware groups: Guest
|--------------------------------------------------------------------------
|
| Here is detected that user is unlogged.
|
*/

namespace App\Http\Middleware;
use Libs\User;
use Libs\Http\Redirect;

class GuestMiddleware {

    public function __construct () {
        if (User::check()) {
            Redirect::to("home.index");
        }
    }

}