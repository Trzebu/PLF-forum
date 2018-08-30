<?php

namespace App\Http\Controllers;
use Libs\View;
use Libs\Token;
use Libs\Validation\Validation;
use Libs\Validation\ValidationErrors;
use Libs\Session;
use Libs\Http\Redirect;
use Libs\Translate;
use Libs\Http\Request;

class Controller {

    public function __construct () {
        $this->view = new View();
        $this->view->token = new Token();
        $this->view->errors = new ValidationErrors();
        $this->view->translate = new Translate();
    }

    protected function validation ($post, $filters) {
        $validation = new Validation($post, $filters);

        if ($validation->errors() !== null) {
            ValidationErrors::set($validation->errors());
            Request::old($post);
        }

        return $validation->check();
    }

    protected function redirect ($path) {
        return Redirect::to($path);
    }

}