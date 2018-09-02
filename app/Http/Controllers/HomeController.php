<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Section;

final class HomeController extends Controller {

    public function index () {
        $section = new Section();

        $this->view->sections = $section->getSections();
        $this->view->section = $section;

        $this->view->render("home.index");
    }

}