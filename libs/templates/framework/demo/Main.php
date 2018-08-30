<?php

namespace Libs\Templates\Framework\Demo;
use App\Http\Controllers\Controller;

final class Main extends Controller {

    public function index () {
        require_once(__ROOT__ . "/libs/templates/framework/demo/index.php");
    }

}