<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Section;
use App\Models\Vote;
use App\Models\ModerationNotes;
use Libs\Token;
use Libs\Session;
use Libs\Config;
use Libs\Http\Request;
use Libs\User as Auth;
use Libs\Tools\SlugUrl;
include __ROOT__ . "/libs/Bbcode/BbCode.php";

final class PostController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->section = new Section();
        $this->post = new Post();
        $this->notes = new ModerationNotes();
    }

    public function editPostSend ($postId) {
        $postData = $this->post->getAnswer($postId);

        if ($postData == null) {
            return $this->redirect("home.index");
        }

        if ($postData->user_id != Auth()->data()->id && !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if ($postData->parent > 0) {
            if (!Auth::permissions("creating_answers")) {
                Session::flash("alert_error", "You can not edit this answer, because you have no permissions to creating answers.");
                return $this->redirect("home.index");
            }
        } else {
            if (!Auth::permissions("create_thread")) {
                Session::flash("alert_error", "You can not edit this thread, because you have no permissions to creating threads.");
                return $this->redirect("home.index");
            }
        }

        if ($postData->status == 1 && !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if ($postData->contents == Request::input("post")) {
            Session::flash("alert_error", "Not found difference between content in database!");
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "post" => "required|str>min:10|str>max:65500",
            "post_token" => "token"
        ])) {
            $this->notes->editPostNote($postData->id, $postData->contents, Request::input("post"));
            $this->post->editPost($postData->id, strip_tags(Request::input("post")));
        }

        if ($postData->parent > 0) {
            //redirect to answer
            return $this->redirect("post.to_post_index", [
                "sectionName" => $this->section->getSection($this->section->getCategory($postData->category)->parent)->url_name,
                "categoryId" => $this->section->getCategory($postData->category)->url_name,
                "postId" => $this->post->getAnswer($postData->parent)->id,
                "answerId" => "#post_{$postData->id}"
            ]);
        }

        return $this->redirect("post.slug_index", [
            "sectionName" => $this->section->getSection($this->section->getCategory($postData->category)->parent)->url_name,
            "categoryId" => $this->section->getCategory($postData->category)->url_name,
            "postId" => $postData->id,
            "postSlugUrl" => SlugUrl::generate($postData->subject)
        ]);

    }

    public function editPost ($postId, $token) {
        $postData = $this->post->getAnswer($postId);

        if (!Token::check("url_token", $token)) {
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("create_thread")) {
            Session::flash("alert_error", "You can not create new thrade, because you have no permissions to creating threads.");
            return $this->redirect("home.index");
        }

        if ($postData == null) {
            return $this->redirect("home.index");
        }

        if ($postData->user_id != Auth()->data()->id && !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if ($postData->status == 1 && !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        $this->view->post = $postData;
        $this->view->render("post.editPost");
    }

    public function actionAnswer ($action, $id, $token) {
        $answer = $this->post->getAnswer($id);

        if ($answer == null) {
            return $this->redirect("home.index");
        }

        if (!$this->section->checkPermissions($answer->category)) {
            return $this->redirect("home.index");
        }

        if (!Token::check('url_token', $token)) {
            return $this->redirect("home.index");
        }

        $action = $action == "remove" ? 1 : 0;
        $this->notes->removeRestoryNote($id, $action == 1 ? "removed" : "restored");

        $this->post->changeAnswerStatus($id, $action);

        return $this->redirect("post.slug_index", [
            "sectionName" => $this->section->getSection($this->section->getCategory($answer->category)->parent)->url_name,
            "categoryId" => $this->section->getCategory($answer->category)->url_name,
            "postId" => $answer->parent,
            "postSlugUrl" => SlugUrl::generate($this->post->getSubjectData($answer->parent, $this->section->getCategory($answer->category)->id)->subject)
        ]); 

    } 

    public function openThread ($postId, $categoryId) {
        if ($this->post->getSubjectData($postId, $categoryId) === null) {
            return $this->redirect("home.index");
        }

        if (!$this->section->checkPermissions($this->post->getSubjectData($postId, $categoryId)->category)) {
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "open_thread_token" => "token"
        ])) {
            $this->notes->openCloseNote($postId, "open");
            $this->post->openThread($postId);
        }

        return $this->redirect("post.slug_index", [
            "sectionName" => $this->section->getSection($this->section->getCategory($categoryId)->parent)->url_name,
            "categoryId" => $categoryId,
            "postId" => $postId,
            "postSlugUrl" => SlugUrl::generate($this->post->getSubjectData($postId, $categoryId)->subject)
        ]); 

    }

    public function closeThread ($postId, $categoryId) {
        if ($this->post->getSubjectData($postId, $categoryId) === null) {
            return $this->redirect("home.index");
        }

        if ($this->post->getSubjectData($postId, $categoryId)->user_id != Auth::data()->id 
            && !$this->section->checkPermissions($this->post->getSubjectData($postId, $categoryId)->category)) {
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "close_thread_token" => "token"
        ])) {
            if ($this->section->checkPermissions($this->post->getSubjectData($postId, $categoryId)->category)) {
                $this->notes->openCloseNote($postId, "close");
            }
            $this->post->closeThread($postId);
        }

        return $this->redirect("post.slug_index", [
            "sectionName" => $this->section->getSection($this->section->getCategory($categoryId)->parent)->url_name,
            "categoryId" => $categoryId,
            "postId" => $postId,
            "postSlugUrl" => SlugUrl::generate($this->post->getSubjectData($postId, $categoryId)->subject)
        ]);        
    }

    public function moveTo ($postId, $categoryId) {
        if ($this->post->getSubjectData($postId, $categoryId) === null) {
            return $this->redirect("home.index");
        }

        if (!$this->section->checkPermissions($this->post->getSubjectData($postId, $categoryId)->category)) {
            return $this->redirect("home.index");
        }

        if ($this->section->getCategory(Request::input("category")) === null) {
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "move_to_token" => "token"
        ])) {
            $this->notes->moveToNote($postId, Request::input("category"));
            $this->post->moveTo($postId, Request::input("category"));
        }


        return $this->redirect("post.slug_index", [
            "sectionName" => $this->section->getSection($this->section->getCategory(Request::input('category'))->parent)->url_name,
            "categoryId" => $this->section->getCategory(Request::input('category'))->url_name,
            "postId" => $postId,
            "postSlugUrl" => SlugUrl::generate($this->post->getSubjectData($postId, Request::input('category'))->subject)
        ]);

    }

    public function addSubjectPost ($categoryId) {
        if ($this->section->getCategory($categoryId) === null) {
            Session::flash("alert_error", "Given category dosen't exists.");
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("create_thread")) {
            Session::flash("alert_error", "You can not create new thrade, because you have no permissions to creating threads.");
            return $this->redirect("home.index");
        }

        if (($this->section->getCategory($categoryId)->status == 1 
            || $this->section->getCategory($categoryId)->status == 2) 
            && !$this->section->checkPermissions($section->getCategory($categoryId)->id)) {
            Session::flash("alert_error", "You can not write anything because this category is closed.");
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "title" => "required|str>min:" .
                        Config::get("posting/title/length/min") .
                        "|str>max:120" .
                        Config::get("posting/title/length/max"),
            "post" => "required|str>min:" .
                        Config::get("posting/contents/length/min") . "|str>max:" .
                        Config::get("posting/contents/length/max"),
            "post_token" => "token" 
        ])) {

            $id = $this->post->addNewSubject(
                Request::input("title"),
                strip_tags(Request::input("post")),
                $categoryId
            );

            return $this->redirect("post.slug_index", [
                "sectionName" => $this->section->getSection($this->section->getCategory($categoryId)->parent)->url_name,
                "categoryId" => $this->section->getCategory($categoryId)->url_name,
                "postId" => $id,
                "postSlugUrl" => SlugUrl::generate(Request::input("title"))
            ]);

        }

        $this->redirect("post.add_subject_to_category", [
            "sectionName" => $this->section->getSection($this->section->getCategory($categoryId)->parent)->url_name,
            "categoryId" => $categoryId
        ]);

    }

    public function addSubject ($sectionName, $categoryId) {
        if ($this->section->getCategory($categoryId) === null) {
            Session::flash("alert_error", "Given category dosen't exists.");
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("create_thread")) {
            Session::flash("alert_error", "You can not create new thrade, because you have no permissions to creating threads.");
            return $this->redirect("home.index");
        }

        $this->view->section = $this->section->getCategory($categoryId);
        $this->view->sectionName = $this->section->getSection($this->view->section->parent)->name;
        $this->view->render("post.addSubject");

    }

    public function addAnswer ($sectionName, $categoryId, $postId) {
        $error = "";

        if (!Auth::permissions("creating_answers")) {
            $error = "You can not write anything, because you have no permissions to creating answers.";
        }

        if ($this->section->getCategory($categoryId) === null) {
            $error = "This section dosn't exists!";
        }

        if ($this->post->getSubjectData($postId, $this->section->getCategory($categoryId)->id) === null) {
            $error = "This subject dosn't exists!";
        }

        if ($this->post->getSubjectData($postId, $this->section->getCategory($categoryId)->id)->status == 1) {
            $error = "This subject has been closed!";
        }

        if ($this->section->getSection($this->section->getCategory($categoryId)->id)->status == 1 ||
            $this->post->getSubjectData($postId, $this->section->getCategory($categoryId)->id)->status == 1 ||
            $this->section->getSection($this->section->getCategory($categoryId)->id)->status == 2) {
                $error = "This thread is closed!";
        }

        if (strlen($error) > 0 && !$this->section->checkPermissions($this->section->getCategory($categoryId)->id)) {
            Session::flash("alert_error", $error);
            return $this->redirect('home.index');
        }

        if ($this->validation(Request::input(), [
            "post" => "required|str>min:" .
                        Config::get("posting/answers/contents/length/min") . "|str>max:" .
                        Config::get("posting/answers/contents/length/max"),
            "post_token" => "token"
        ])) {

            Session::flash("alert_success", "Your answer has been added to this thrade!");
            $this->post->newAnswer(
                $postId,
                $this->section->getCategory($categoryId)->id,
                strip_tags(Request::input("post"))
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
        $this->view->parent_post = $this->post->getSubjectData($postId, $this->section->getCategory($categoryId)->id);
        if ($this->view->parent_post !== null) {

            if ($this->section->getCategory($categoryId)->status == 2 && !$this->section->checkPermissions($this->section->getCategory($categoryId)->id)) {
                return $this->redirect("home.index");
            }

            $this->view->title = "{$this->view->parent_post->subject} - Forum";
            $this->post->visitIncrement($postId);
            $this->view->postObj = $this->post;
            $this->view->user = new User();
            $this->view->vote = new Vote();
            $this->view->reportToken = Token::generate("report_token");
            $this->view->urlToken = Token::generate("url_token");
            $this->view->section_id = $sectionName;
            $this->view->category_id = $categoryId;
            $this->view->hasPermissions = false;
            $this->view->threadBlockedReason = "";
            $this->view->bb = new \BbCode();

            if ($this->section->checkPermissions($this->section->getCategory($categoryId)->id)) {
                $this->view->hasPermissions = true;
                $this->view->categories = $this->section->getAllCategories();
            }

            /*Checking post status*/

            if (!Auth::check()) {
                $this->view->threadBlockedReason = "You must be logged if you want to write something in this thread.";
            } else if (!Auth()->permissions('creating_answers')) {
                $this->view->threadBlockedReason = "You can not write anything, because you have no permissions to creating answers.";
            } else if ($this->section->getCategory($categoryId)->status == 1) {
                $this->view->threadBlockedReason = "You can not write anything, because this category is closed by Moderator or Administrator.";
            } else if ($this->view->parent_post->status == 1) {
                $this->view->threadBlockedReason = "You can not write anything, because this thread is closed.";
            }

        }

        $this->view->render("post.viewIndex");
    }

}