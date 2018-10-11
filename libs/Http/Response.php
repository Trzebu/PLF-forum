<?php

namespace Libs\Http;

class Response {

    private static $_headers = [
        "404" => "HTTP/1.0 404 Not Found",
        "403" => "HTTP/1.0 403 Forbidden",
    ];

    public function header ($name) {
        header(self::$_headers[$name]);
    }

}