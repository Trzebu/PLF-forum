<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Post;
use App\Models\User;

final class HomeController extends Controller {

    public function index () {
        $section = new Section();
    
        $this->view->sections = $section->getSections();
        $this->view->section = $section;
        $this->view->postObj = new Post();
        $this->view->user = new User();

        $this->view->render("home.index");
    }

}