<?php

use Libs\Token;

function token ($name) {
    return Token::generate($name);
}