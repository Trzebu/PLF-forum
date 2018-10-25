<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;
use Libs\Session;

final class SectionController extends Controller {

    public function index () {
        $section = new Section();

        $this->view->sections = $section->getSections();
        $this->view->section = $section;
        $this->view->postObj = new Post();
        $this->view->user = new User();
        $this->view->render("home.index");
    }

    public function viewCategories ($sectionId) {
        $section = new Section();
        $this->view->categories = null;

        if ($section->getSectionCategories($sectionId) !== null) {
            $this->view->categories = $section->getSectionCategories($sectionId);
            $this->view->section_details = $section->getSection($sectionId);
            $this->view->section = $section;
            $this->view->postObj = new Post();
            $this->view->user = new User();
        }

        $this->view->render("section.viewCategories");
    }

    public function viewCategoryPosts ($sectionId, $categoryId) {
        $section = new Section();
        $post = new Post();

        $this->view->section_details = $section->getSection($sectionId);
        $this->view->category = $section->getCategory($categoryId);
        $this->view->posts = null;
        $this->view->section = $section;
        $this->view->user = new User();

        if ($this->view->category === null) {
            Session::flash("alert_info", "Category you are searching does not exists.");
            return $this->redirect("home.index");
        }

        if (!is_null($this->view->category->password) &&
            !$this->view->user->isLoggedToCategory($this->view->category->id)) {
            Session::flash("alert_info", trans("auth.category_auth"));
            return $this->redirect("section.login", [
                "sectionName" => $this->view->section_details->url_name,
                "categoryId" => $this->view->category->url_name
            ]);
        }

        if ($this->view->category->status == 2 && !$section->checkPermissions($this->view->category->id)) {
            $this->view->category = null;
        }

        if ($this->view->category !== null) {
            $this->view->vote = new Vote();
            $this->view->postObj = $post;
            $this->view->hasPermissions = $section->checkPermissions($this->view->category->id);
        }

        $this->view->render("section.category_posts");

    }

}