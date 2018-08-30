<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

final class AuthController extends Controller {

    public function indexLogin () {
        $this->view->render("auth.login");
    }

    public function postLogin () {
        
    }

    public function indexRegister () {
        $this->view->render("auth.register");
    }

    public function postRegister () {
        
    }

}