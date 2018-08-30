<?php

namespace Libs;
use Libs\Session;

class Token {

    public static function generate ($name) {
        return Session::set($name, md5(uniqid()));
    }

    public static function check ($name, $token) {
        if (Session::exists($name) && $token === Session::get($name)) {
            return true;
        }
        return false;
    }

}