<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

final class Home extends Controller {

    public function index () {
        $this->view->render("home.index");
    }

}