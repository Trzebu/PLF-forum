<?php

use Libs\Config;

function config ($path) {
    return Config::get($path);
}