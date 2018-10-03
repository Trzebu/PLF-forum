<?php

namespace Libs;

use Libs\DataBase\DataBase;

class Config {

    public static function loadRegistry () {
        $configs = DataBase::instance()->table("system_registry")->get(["registry_name", "value", "type"])->results();

        foreach ($configs as $conf) {
            $GLOBALS = array_merge($GLOBALS, [$conf->registry_name => [$conf->value, $conf->type]]);
        }
    }

    public static function get($path = NULL, $as_arr = false) {
        if ($path) {
            if (isset($GLOBALS[$path])) {
                $val = $GLOBALS[$path][0];
                $type = $GLOBALS[$path][1];
                if ($type == "int") {
                    return (int) $val;
                } else if ($type == "str") {
                    return (string) $val;
                } else if ($type == "bool") {
                    return (boolean) $val;
                } else if ($type == "arr") {
                    return (object) $val;
                } else if ($type == "unset") {
                    return (unset) null;
                } else {
                    return $val;
                }

            }

            $path = explode('/', $path);
            $config = $GLOBALS['constants'];
            
            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }

            if (is_array($config) && !$as_arr) {
                return "Unknown config path. " . implode("/", $path);
            }

            return $config;
        }

        return false;
    }
}