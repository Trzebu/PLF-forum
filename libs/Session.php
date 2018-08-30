<?php

namespace Libs;

session_start();

class Session {

    public static function set ($name, $value) {
        return $_SESSION[$name] = $value;
    }

    public static function get ($name) {

        if (self::exists($name)) {
            return $_SESSION[$name];
        }

        return false;
    }

    public static function unset ($name) {
        unset($_SESSION[$name]);
        return true;
    }

    public static function exists ($name) {
        return (bool) isset($_SESSION[$name]);
    }

    public static function destroy () {
        session_destroy();
    }

    public static function flash ($name, $string = null) {

        if (self::exists($name)) {
            $session = self::get($name);
            self::unset($name);
            return $session;
        } else {
            self::set($name, $string);
        }
    }

}