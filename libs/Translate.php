<?php

namespace Libs;
use Libs\Config;
use Libs\Cookie;

class Translate {

    private static $_path = null;
    private static $_file = null;

    public static function changeLang ($lang) {
        foreach (Config::get("langs", true) as $key => $value) {
            if ($key == $lang) {
                Cookie::put("language", $lang, 2592000);
                return true;
            }
        }

        return false;

    }

    public static function getUserLanguage () {
        if (Cookie::exists("language")) {
            return Cookie::get("language");
        } else {
            return Config::get("default_lang");
        }
    }

    private static function openFile ($path) {

        if (self::$_path === null || self::$_path != $path) {
            self::$_path = $path;
            self::$_file = require_once($path);
            return self::$_file;
        }

        return self::$_file;

    }

    public static function get ($path) {
        $path = explode(".", $path);
        $file = __ROOT__ . Config::get("langs/" . self::getUserLanguage(), true)[0] . "/" . $path[0] . ".php";
        if (file_exists($file)) {
            $file = self::openFile($file);
            array_shift($path);

            foreach ($path as $bit) {
                if (isset($file[$bit])) {
                    $file = $file[$bit];
                }
            }

            return is_array($file) ? implode(".", $path) : $file;

        }
        return implode(".", $path);
    }

}