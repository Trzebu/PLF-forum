<?php

spl_autoload_register( function ($class) {

    $filename = __ROOT__ . '\\' . $class . '.php';

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