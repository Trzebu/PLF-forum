<?php

namespace Libs\Templates\Framework\Errors\Error_404;
use App\Http\Controllers\Controller;

final class Error extends Controller {

    public function index () {
        require_once(__ROOT__ . "/libs/templates/framework/errors/error_404/index.php");
    }

}