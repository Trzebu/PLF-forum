<?php

namespace Libs\Http;

class Redirect {

    public function to ($path) {
        return header("Location: " . route($path));
    }

}