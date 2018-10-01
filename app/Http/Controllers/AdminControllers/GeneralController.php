<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;

final class GeneralController extends Controller {

    public function generalView () {
        $this->view->render("admin.general.general");
    }

}