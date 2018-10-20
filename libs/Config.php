<?php

namespace Libs;

use App\Models\AdminModels\SystemRegistry;
use Libs\DataBase\DataBase;

class Config {

    public static function edit ($register, $value) {
        $db = DataBase::instance()->table("system_registry");
        $reg = new SystemRegistry();
        $reg_data = $db->where("registry_name", "=", $register)->get()->results();

        if (count($reg_data) < 1) {
            dd("Register {$register} dose not exists.");
        }

        if (!$reg->permissions($reg_data[0]->mode, "edit_value")) {
            dd("Register {$register} can't by edited. Mod {$reg_data[0]->mode}");
        }

        if (!$reg->valueType($reg_data[0]->type, $value)) {
            dd("Register {$register} must be a type of {$reg_data[0]->type}.");
        }

        $db->where("registry_name", "=", $register)->update([
            "value" => $value
        ]);

    }

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
                    return $val === "true" ? true : false;
                } else if ($type == "json") {
                    return json_decode($val);
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