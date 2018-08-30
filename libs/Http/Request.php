<?php

namespace Libs\Http;
use Libs\Session;

class Request {
    private static $_urlVars = [];

    public static function urlVar ($var = null) {
        if ($var != null) {
            foreach (self::$_urlVars as $vars) {
                if (isset($vars[$var])) {
                    return $vars[$var];
                }
            }
            return null;
        }
        return count(self::$_urlVars) > 0 ? self::$_urlVars : null;
    }

    public function old ($name = null) {
        if ($name !== null) {
            if (is_array($name)) {
                Session::set("Request_old_inputs", $name);
            }
            if (Session::exists("Request_old_inputs")) {
                if (isset(Session::get("Request_old_inputs")[$name])) {
                    $data = Session::get("Request_old_inputs")[$name];
                    unset($_SESSION["Request_old_inputs"][$name]);
                    return $data;
                }
            }
        }
        return "";
    }

    public function input ($name = null) {
        if ($name !== null) {
            return isset($_POST[$name]) ? $_POST[$name] : null;
        }
        return $_POST;
    }

    public static function method ($method) {
        if ($_SERVER["REQUEST_METHOD"] === $method) {
            return true;
        }
        return false;
    }

    public static function clientIP () {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function userAgent () {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public static function getMethod () {
        return $_SERVER["REQUEST_METHOD"];
    }
    
    public static function url () {
        $url = $_SERVER['REQUEST_URI'];

        if (strlen($url) > 1000) {
            return "/";
        }

        if (strpos($url, "?") === false) {
            return $url;
        }

        $vars = explode("/", $url);
        $mvc_url = [];

        foreach ($vars as $var) {

            if (isset($var[0])) {
                if ($var[0] == "?") {
                    $query = explode("=", ltrim($var, "?"));
                    if (isset($query[0]) && isset($query[1])) {
                        array_push(self::$_urlVars, [$query[0] => $query[1]]);
                    }
                } else {
                    array_push($mvc_url, $var);
                }
            }

        }

        return "/" . implode("/", $mvc_url);
    }

}