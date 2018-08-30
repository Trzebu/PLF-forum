<?php

namespace Libs;

class Config {
    public static function get($path = NULL, $as_arr = false) {
        if ($path) {
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