<?php

namespace Libs;
use Libs\Config;
use Libs\Cookie;

class Translate {

    private static $_path = null;
    private static $_file = null;

    public static function changeLang ($lang) {
        if (in_array($lang, scandir(__ROOT__ . "/resources/lang"))) {
            Cookie::put("language", $lang, Config::get("page/language/cookie_expiry"));
            return true;
        }

        return false;
    }

    public static function getUserLanguage () {
        if (Cookie::exists("language")) {
            return Cookie::get("language");
        } else {
            return Config::get("page/language/default");
        }
    }

    private static function openFile ($path) {

        if (self::$_path === null || self::$_path != $path) {
            self::$_path = $path;
            self::$_file = include($path);
            return self::$_file;
        }

        return self::$_file;

    }

    public static function get ($path) {
        $path = explode(".", $path);
        $file = __ROOT__ . "/resources/lang/" . self::getUserLanguage() . "/" . $path[0] . ".php";
        if (file_exists($file)) {
            $file = self::openFile($file);
            array_shift($path);

            foreach ($path as $bit) {
                if (isset($file[$bit])) {
                    $file = $file[$bit];
                }
            }

            return $file;

        }
        return implode(".", $path);
    }

}