<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Post;
use App\Models\User;

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
        $this->view->posts = $post->getPosts($this->view->category->id);
        $this->view->postObj = $post;
        $this->view->user = new User();

        $this->view->render("section.category_posts");

    }

}