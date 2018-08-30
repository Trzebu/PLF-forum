<?php

//Die Dump function

function dd ($expression = null) {
    echo "<pre>" , var_dump($expression) , "</pre>";
    die();
}