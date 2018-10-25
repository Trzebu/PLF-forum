<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;

final class GeneralController extends Controller {

    public function phpInfo () {
        $this->view->render("admin.general.php_info");
    }

    public function generalView () {
        $this->view->render("admin.general.general");
    }

}