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
        $this->view->title = "Forum";
    }

    protected function validation ($fields, $filters) {
        Validation::start($fields, $filters);

        if (!Validation::check()) {
            ValidationErrors::set(Validation::errorsGetter());
            Request::old($fields);
        }

        return Validation::check();
    }

    protected function redirect ($path, $params = []) {
        return Redirect::to($path, $params);
    }

}