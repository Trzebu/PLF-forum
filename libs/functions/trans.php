<?php
use Libs\Translate;

function trans ($path) {
    return Translate::get($path);
}