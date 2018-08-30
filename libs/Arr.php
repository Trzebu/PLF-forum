<?php

namespace Libs;

class Arr {

    public static function fixLowHigh ($array) {
        $fixed = [];

        foreach ($array as $value) {
            array_push($fixed, $value);
        }

        return $fixed;
    }

}