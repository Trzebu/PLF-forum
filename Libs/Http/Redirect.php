<?php

namespace Libs\Http;

class Redirect {

    public function to ($path, $params = []) {
        return header("Location: " . route($path, $params));
    }

}