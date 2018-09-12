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
use Libs\Tools\SlugUrl;
include __ROOT__ . "/libs/Bbcode/BbCode.php";

final class PostController extends Controller {

    public function editPostSend ($postId) {

        $post = new Post();
        $section = new Section();
        $postData = $post->getAnswer($postId);

        if ($postData == null) {
            return $this->redirect("home.index");
        }

        if ($postData->user_id != Auth()->data()->id && !$section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if ($postData->status == 1 && !$section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if ($postData->contents == Request::input("post")) {
            Session::flash("alert_error", "Not found difference between content in database!");
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "post" => "required|min_string:10|max_string:65500",
            "post_token" => "token"
        ])) {
            $bb = new \BbCode();
            $bb->parse(strip_tags(Request::input("post"), false));

            $post->editPost($postData->id, $bb->getHtml());
        }

        if ($postData->parent > 0) {
            //redirect to answer
            return $this->redirect("post.to_post_index", [
                "sectionName" => $section->getSection($section->getCategory($postData->category)->parent)->url_name,
                "categoryId" => $section->getCategory($postData->category)->url_name,
                "postId" => $post->getAnswer($postData->parent)->id,
                "answerId" => "#post_{$postData->id}"
            ]);
        }

        return $this->redirect("post.slug_index", [
            "sectionName" => $section->getSection($section->getCategory($postData->category)->parent)->url_name,
            "categoryId" => $section->getCategory($postData->category)->url_name,
            "postId" => $postData->id,
            "postSlugUrl" => SlugUrl::generate($postData->subject)
        ]);

    }

    public function editPost ($postId, $token) {

        $post = new Post();
        $section = new Section();
        $postData = $post->getAnswer($postId);

        if (!Token::check("url_token", $token)) {
            return $this->redirect("home.index");
        }

        if ($postData == null) {
            return $this->redirect("home.index");
        }

        if ($postData->user_id != Auth()->data()->id && !$section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if ($postData->status == 1 && !$section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        $this->view->post = $postData;
        $this->view->render("post.editPost");
    }

    public function actionAnswer ($action, $id, $token) {

        $post = new Post();
        $section = new Section();
        $answer = $post->getAnswer($id);

        if ($answer == null) {
            return $this->redirect("home.index");
        }

        if (!$section->checkPermissions($answer->category)) {
            return $this->redirect("home.index");
        }

        if (!Token::check('url_token', $token)) {
            return $this->redirect("home.index");
        }

        $action = $action == "remove" ? 1 : 0;

        $post->changeAnswerStatus($id, $action);

        return $this->redirect("post.slug_index", [
            "sectionName" => $section->getSection($section->getCategory($answer->category)->parent)->url_name,
            "categoryId" => $section->getCategory($answer->category)->url_name,
            "postId" => $answer->parent,
            "postSlugUrl" => SlugUrl::generate($post->getSubjectData($answer->parent, $section->getCategory($answer->category)->id)->subject)
        ]); 

    } 

    public function openThread ($postId, $categoryId) {
        $post = new Post();
        $section = new Section();

        if ($post->getSubjectData($postId, $categoryId) === null) {
            return $this->redirect("home.index");
        }

        if (!$section->checkPermissions($post->getSubjectData($postId, $categoryId)->category)) {
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "open_thread_token" => "token"
        ])) {
            $post->openThread($postId);
        }

        return $this->redirect("post.slug_index", [
            "sectionName" => $section->getSection($section->getCategory($categoryId)->parent)->url_name,
            "categoryId" => $categoryId,
            "postId" => $postId,
            "postSlugUrl" => SlugUrl::generate($post->getSubjectData($postId, $categoryId)->subject)
        ]); 

    }

    public function closeThread ($postId, $categoryId) {
        $post = new Post();
        $section = new Section();

        if ($post->getSubjectData($postId, $categoryId) === null) {
            return $this->redirect("home.index");
        }

        if ($post->getSubjectData($postId, $categoryId)->user_id != Auth::data()->id && !$section->checkPermissions($post->getSubjectData($postId, $categoryId)->category)) {
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "close_thread_token" => "token"
        ])) {
            $post->closeThread($postId);
        }

        return $this->redirect("post.slug_index", [
            "sectionName" => $section->getSection($section->getCategory($categoryId)->parent)->url_name,
            "categoryId" => $categoryId,
            "postId" => $postId,
            "postSlugUrl" => SlugUrl::generate($post->getSubjectData($postId, $categoryId)->subject)
        ]);        
    }

    public function moveTo ($postId, $categoryId) {
        $post = new Post();
        $section = new Section();

        if ($post->getSubjectData($postId, $categoryId) === null) {
            return $this->redirect("home.index");
        }

        if (!$section->checkPermissions($post->getSubjectData($postId, $categoryId)->category)) {
            return $this->redirect("home.index");
        }

        if ($section->getCategory(Request::input("category")) === null) {
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "move_to_token" => "token"
        ])) {
            $post->moveTo($postId, Request::input("category"));
        }

        return $this->redirect("post.slug_index", [
            "sectionName" => $section->getSection($section->getCategory(Request::input('category'))->parent)->url_name,
            "categoryId" => $section->getCategory(Request::input('category'))->url_name,
            "postId" => $postId,
            "postSlugUrl" => SlugUrl::generate($post->getSubjectData($postId, Request::input('category'))->subject)
        ]);

    }

    public function addSubjectPost ($categoryId) {
        $section = new Section();

        if ($section->getCategory($categoryId) === null) {
            Session::flash("alert_error", "Given category dosen't exists.");
            return $this->redirect("home.index");
        }

        if (Auth::permissions("banned")) {
            Session::flash("alert_error", "You can not create new thrade, because you have account block.");
            return $this->redirect("home.index");
        }

        if (($section->getCategory($categoryId)->status == 1 || $section->getCategory($categoryId)->status == 2) &&
            !$section->checkPermissions($section->getCategory($categoryId)->id)) {
            Session::flash("alert_error", "You can not write anything because this category is closed.");
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "title" => "required|min_string:10|max_string:120",
            "post" => "required|min_string:10|max_string:65500",
            "post_token" => "token" 
        ])) {
            $post = new Post();

            $bb = new \BbCode();
            $bb->parse(strip_tags(Request::input("post"), false));

            $id = $post->addNewSubject(
                Request::input("title"),
                $bb->getHtml(),
                $categoryId
            );

            return $this->redirect("post.slug_index", [
                "sectionName" => $section->getSection($section->getCategory($categoryId)->parent)->url_name,
                "categoryId" => $section->getCategory($categoryId)->url_name,
                "postId" => $id,
                "postSlugUrl" => SlugUrl::generate(Request::input("title"))
            ]);

        }

        $this->redirect("post.add_subject_to_category", [
            "sectionName" => $section->getSection($section->getCategory($categoryId)->parent)->url_name,
            "categoryId" => $categoryId
        ]);

    }

    public function addSubject ($sectionName, $categoryId) {

        $section = new Section();

        if ($section->getCategory($categoryId) === null) {
            Session::flash("alert_error", "Given category dosen't exists.");
            return $this->redirect("home.index");
        }

        if (Auth::permissions("banned")) {
            Session::flash("alert_error", "You can not create new thrade, because you have account block.");
            return $this->redirect("home.index");
        }

        $this->view->section = $section->getCategory($categoryId);
        $this->view->sectionName = $section->getSection($this->view->section->parent)->name;
        $this->view->render("post.addSubject");

    }

    public function addAnswer ($sectionName, $categoryId, $postId) {
        $post = new Post();
        $section = new Section();

        $error = "";

        if (Auth::permissions("banned")) {
            $error = "You can not write anything because you have been blocked.";
        }

        if ($section->getCategory($categoryId) === null) {
            $error = "This section dosn't exists!";
        }

        if ($post->getSubjectData($postId, $section->getCategory($categoryId)->id) === null) {
            $error = "This subject dosn't exists!";
        }

        if ($post->getSubjectData($postId, $section->getCategory($categoryId)->id)->status == 1) {
            $error = "This subject has been closed!";
        }

        if ($section->getSection($section->getCategory($categoryId)->id)->status == 1 ||
            $post->getSubjectData($postId, $section->getCategory($categoryId)->id)->status == 1 ||
            $section->getSection($section->getCategory($categoryId)->id)->status == 2) {
                $error = "This thread is closed!";
        }

        if (strlen($error) > 0 && !$section->checkPermissions($section->getCategory($categoryId)->id)) {
            Session::flash("alert_error", $error);
            return $this->redirect('home.index');
        }

        if ($this->validation(Request::input(), [
            "post" => "required|min_string:10|max_string:65500",
            "post_token" => "token"
        ])) {
            $bb = new \BbCode();
            $bb->parse(strip_tags(Request::input("post"), false));

            Session::flash("alert_success", "Your answer has been added to this thrade!");
            $post->newAnswer(
                $postId,
                $section->getCategory($categoryId)->id,
                $bb->getHtml()
            );
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

            if ($section->getCategory($categoryId)->status == 2 && !$section->checkPermissions($section->getCategory($categoryId)->id)) {
                return $this->redirect("home.index");
            }

            $post->visitIncrement($postId);
            $this->view->postObj = $post;
            $this->view->user = new User();
            $this->view->vote = new Vote();
            $this->view->urlToken = Token::generate("url_token");
            $this->view->section_id = $sectionName;
            $this->view->category_id = $categoryId;
            $this->view->hasPermissions = false;
            $this->view->threadBlockedReason = "";

            if ($section->checkPermissions($section->getCategory($categoryId)->id)) {
                $this->view->hasPermissions = true;
                $this->view->categories = $section->getAllCategories();
            }

            /*Checking post status*/

            if (!Auth::check()) {
                $this->view->threadBlockedReason = "You must be logged if you want to write something in this thread.";
            } else if (Auth()->permissions('banned')) {
                $this->view->threadBlockedReason = "You can not write anything, because you have been blocked.";
            } else if ($section->getCategory($categoryId)->status == 1) {
                $this->view->threadBlockedReason = "You can not write anything, because this category is closed by Moderator or Administrator.";
            } else if ($this->view->parent_post->status == 1) {
                $this->view->threadBlockedReason = "You can not write anything, because this thread is closed.";
            }

        }

        $this->view->render("post.viewIndex");
    }

}