<?php

namespace Libs;

class Str {

    public static function replace ($string, $fields) {
        foreach ($fields as $key => $value) {
            $string = str_replace($key, $value, $string);
        }

        return $string;
    }

}