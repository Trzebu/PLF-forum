<?php

spl_autoload_register( function ($class) {

    $class = str_replace("\\", "/", $class);

    $filename = __ROOT__ . '/' . $class . '.php';

    try {
        if (!file_exists($filename)) {
            Throw new Exception("Class {$filename} not found.");
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }

    include $filename;
    return true;

});