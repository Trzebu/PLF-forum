<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Section;
use App\Models\Vote;
use Libs\Token;
use Libs\Session;
use Libs\Http\Request;
use Libs\User as Auth;

final class PostController extends Controller {

    public function addAnswer ($sectionName, $categoryId, $postId) {
        $post = new Post();
        $section = new Section();

        if (Auth::permissions("banned")) {
            Session::flash("alert_error", "You can not write anything because you have been blocked.");
            return $this->redirect('home.index');
        }

        if ($section->getCategory($categoryId) === null) {
            Session::flash("alert_error", "This section dosn't exists!");
            return $this->redirect('home.index');
        }

        if ($post->getSubjectData($postId, $section->getCategory($categoryId)->id) === null) {
            Session::flash("alert_error", "This subject dosn't exists!");
            return $this->redirect('home.index');
        }

        if ($this->validation(Request::input(), [
            "post" => "required|min_string:10|max_string:65500",
            "post_token" => "token"
        ])) {
            Session::flash("alert_success", "Your answer has been added to this thrade!");
            $post->newAnswer($postId, $section->getCategory($categoryId)->id, Request::input("post"));
        }

        return $this->redirect('post.to_post_index', [
            'sectionName' => $sectionName,
            'categoryId' => $categoryId,
            'postId' => $postId,
            'answerId' => "#post"
        ]);

    }

    public function viewIndex ($sectionName, $categoryId, $postId, $postSlugUrl = null) {
        $post = new Post();
        $section = new Section();

        $this->view->parent_post = $post->getSubjectData($postId, $section->getCategory($categoryId)->id);
        if ($this->view->parent_post !== null) {
            $post->visitIncrement($postId);
            $this->view->answers = $post;
            $this->view->user = new User();
            $this->view->vote = new Vote();
            $this->view->urlToken = Token::generate("url_token");
            $this->view->section_id = $sectionName;
            $this->view->category_id = $categoryId;
        }

        $this->view->render("post.viewIndex");
    }

}