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
        $this->user = new User();
    }

    public function deleteAnswer ($section, $category, $postId, $token) {
        $data = $this->post->postGetter($postId);

        if (!Token::check("delete_answer_token", $token)) {
            return $this->redirect("home.index");
        }

        if ($data === null) {
            return $this->redirect("home.index");
        }

        if (!$this->section->checkPermissions($this->post->postGetter($postId)->category)) {
            Session::flash("alert_error", "U have no permissions.");
            return $this->redirect("home.index");
        }

        $this->post->deletePost($postId);

        Session::flash("alert_success", "Answer has been deleted!");
        $this->redirect("post.slug_index", [
                        "sectionName" => $section,
                        "categoryId" => $category,
                        "postId" => $data->parent,
                        "postSlugUrl" => SlugUrl::generate($this->post->postGetter($data->parent)->subject)
                    ]);
    }

    public function deleteThread ($postId, $token) {

        if (!Token::check("delete_thread_token", $token)) {
            return $this->redirect("home.index");
        }

        if ($this->post->postGetter($postId) === null) {
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("global_moderator")) {
            Session::flash("alert_error", "U have no permissions.");
            return $this->redirect("home.index");
        }

        $this->post->deleteThread($postId);

        Session::flash("alert_success", "Thread deleted!");
        $this->redirect("home.index");
    }

    public function editSubjectSend ($section, $category, $postId) {
        $postData = $this->post->postGetter($postId);

        if ($postData == null) {
            return $this->redirect("home.index");
        }

        if (!is_null($this->section->getCategory($category)->password) &&
            !$this->user->isLoggedToCategory($this->section->getCategory($category)->id)) {
            Session::flash("alert_info", trans("auth.category_auth"));
            return $this->redirect("section.login", [
                "sectionName" => $sectionName,
                "categoryId" => $categoryId
            ]);
        }

        if ($this->section->getCategory($category) === null ||
            $this->section->getSection($section) === null) {
            return $this->redirect("home.index");
        }

        if ($postData->user_id != Auth()->data()->id &&
            !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("creating_answers")) {
            Session::flash("alert_error", "You can not edit this answer, because you have no permissions to creating answers.");
            return $this->redirect("home.index");
        }

        if ($postData->status == 1 &&
            !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if (!$this->validation(Request::input(), [
            "title" => "required|str>min:" .
                        Config::get("posting/title/length/min") .
                        "|str>max:" .
                        Config::get("posting/title/length/max"),
            "post" => "required|str>min:" .
                        Config::get("posting/contents/length/min") .
                        "|str>max:" .
                        Config::get("posting/contents/length/max"),
            "post_edit_token" => "token"
        ])) {
            return $this->redirect("post.edit.answer", [
                        "section" => $section,
                        "category" => $category,
                        "postId" => $postId
                    ]);
        }

        $status = Request::input("lock") === "on" ? 1 : 0;
        $sticky = $postData->sticky;
        $color = null;

        if ($this->section->checkPermissions($postData->category)) {
            $sticky = Request::input("type") == 0 ? null : 1;
            $color = Request::input("subject_color");
        }

        $this->post->postUpdate($postId, [
            "status" => $status,
            "sticky" => $sticky,
            "subject_color" => $color,
            "subject" => Request::input("title"),
            "contents" => Request::input("post")
        ]);

        Session::flash("alert_info", "Thread updated!");
        $this->redirect("post.slug_index", [
            "sectionName" => $section,
            "categoryId" => $category,
            "postId" => $postId,
            "postSlugUrl" => SlugUrl::generate(Request::input("title"))
        ]);
    }

    public function addSubjectGlobalSend () {
        if (!Auth::permissions("create_thread")) {
            Session::flash("alert_error", "You can not create new thrade, because you have no permissions to creating threads.");
            return $this->redirect("home.index");
        }

        if (!$this->validation(Request::input(), [
            "title" => "required|str>min:" .
                        Config::get("posting/title/length/min") .
                        "|str>max:" .
                        Config::get("posting/title/length/max"),
            "post" => "required|str>min:" .
                        Config::get("posting/contents/length/min") .
                        "|str>max:" .
                        Config::get("posting/contents/length/max"),
            "post_token" => "token"
        ])) {
            return $this->redirect("post.add_subject");
        }

        $sticky = null;
        $status = null;
        $category = null;
        $cat_data = $this->section->getCategory(Request::input("category"));
        $color = Auth::permissions("moderator") ?
                 !empty(Request::input("color")) ?
                 Request::input("color") :
                 "blue" :
                 "blue";

        if (Request::input("type") == 2 &&
            Auth::permissions("global_moderator")) {
            $category = 0;
        } else if ($cat_data === null) {
            return $this->redirect("post.add_subject");
        } else {
            $category = $cat_data->id;
            if (!is_null($this->section->getCategory($category)->password) &&
                !$this->user->isLoggedToCategory($this->section->getCategory($category)->id)) {
                Session::flash("alert_info", trans("auth.category_auth"));
                return $this->redirect("section.login", [
                    "sectionName" => $sectionName,
                    "categoryId" => $categoryId
                ]);
            }
        }

        $hasPermissions = $cat_data === null &&
                          $category == 0 ? true :
                          $this->section->checkPermissions($cat_data->id);

        if ($hasPermissions) {
            if (Request::input("lock") === "on") {
                $status = 1;
            }
            if (Request::input("type") == 1) {
                $sticky = 1;
            }
        }

        $id = $this->post->addNew([
            "status" => $status,
            "sticky" => $sticky,
            "category" => $category,
            "user_id" => Auth::data()->id,
            "subject" => Request::input("title"),
            "contents" => Request::input("post")
        ]);

        if ($category != 0) {
            $this->redirect("post.slug_index", [
                "sectionName" => $this->section->getSection($cat_data->parent)->url_name,
                "categoryId" => $cat_data->url_name,
                "postId" => $id,
                "postSlugUrl" => SlugUrl::generate(Request::input("title"))
            ]);
        } else {
            Session::flash("alert_success", "The thread has been created!");
            $this->redirect("post.add_subject");
        }
    }

    public function addSubjectGlobal () {
        if (!Auth::permissions("create_thread")) {
            Session::flash("alert_error", "You can not create new thrade, because you have no permissions to creating threads.");
            return $this->redirect("home.index");
        }

        $this->view->section = $this->section;

        $this->view->render("post.addSubjectGlobal");
    }

    public function editAnswerSend ($section, $category, $postId) {
        $postData = $this->post->postGetter($postId);

        if ($postData == null) {
            return $this->redirect("home.index");
        }

        if ($postData->user_id != Auth()->data()->id &&
            !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("creating_answers")) {
            Session::flash("alert_error", "You can not edit this answer, because you have no permissions to creating answers.");
            return $this->redirect("home.index");
        }

        if ($postData->status == 1 &&
            !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if ($postData->contents == Request::input("post")) {
            Session::flash("alert_error", "Not found difference between content in database!");
            return $this->redirect("home.index");
        }

        $min = Config::get("posting/answers/contents/length/min");
        $max = Config::get("posting/answers/contents/length/max");

        if ($this->validation(Request::input(), [
            "post" => "required|str>min:{$min}|str>max:{$max}",
            "post_token" => "token"
        ])) {
            $this->post->postUpdate($postId, [
                "contents" => strip_tags(Request::input("post"))
            ]);
        }

        return $this->redirect("post.to_post_index", [
            "sectionName" => $section,
            "categoryId" => $category,
            "postId" => $postData->parent,
            "answerId" => "#post_{$postData->id}"
        ]);
    }

    public function editAnswer ($section, $category, $postId) {
        $postData = $this->post->postGetter($postId);

        if (!Auth::permissions("create_thread")) {
            Session::flash("alert_error", "You can not edit thrade, because you have no permissions to editing threads.");
            return $this->redirect("home.index");
        }

        if ($postData == null) {
            return $this->redirect("home.index");
        }

        if ($postData->user_id != Auth()->data()->id &&
            !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        if ($postData->status == 1 &&
            !$this->section->checkPermissions($postData->category)) {
            return $this->redirect("home.index");
        }

        $this->view->post = $postData;

        if (is_null($postData->parent)) {
            $this->view->route = route("post.edit.subject.send", [
                                        "section" => $section,
                                        "category" => $category,
                                        "postId" => $postId
                                    ]);
            $this->view->section = $this->section;
            $this->view->categories = $this->section->getAllCategories();
            $this->view->render("post.editSubject");
        } else {
            $this->view->route = route("post.edit.answer.send", [
                                        "section" => $section,
                                        "category" => $category,
                                        "postId" => $postId
                                    ]);
            $this->view->hideAnsRoute = route("post.remove_or_restore", [
                                            "section" => $section,
                                            "categoryId" => $category,
                                            "postId" => $postId,
                                            "token" => token("url_token")
                                        ]);
            $this->view->deleteRoute = route("post.delete.answer", [
                                            "section" => $section,
                                            "category" => $category,
                                            "postId" => $postId,
                                            "token" => token("delete_answer_token")
                                        ]);
            $this->view->render("post.editAnswer");
        }
    }

    public function hideRestoreAnswer ($section, $categoryId, $id, $token) {
        $answer = $this->post->postGetter($id);

        if ($answer == null) {
            return $this->redirect("home.index");
        }

        if (!$this->section->checkPermissions($answer->category)) {
            return $this->redirect("home.index");
        }

        if (!Token::check('url_token', $token)) {
            return $this->redirect("home.index");
        }

        $action = $answer->status == 0 ? 1 : 0;

        $this->post->postUpdate($id, [
            "status" => $action
        ]);

        return $this->redirect("post.to_post_index", [
            "sectionName" => $section,
            "categoryId" => $categoryId,
            "postId" => $answer->parent,
            "answerId" => "#post_{$answer->id}"
        ]); 

    }

    public function moveTo ($postId) {
        if ($this->post->postGetter($postId) === null) {
            return $this->redirect("home.index");
        }

        if (!$this->section->checkPermissions($this->post->postGetter($postId)->category)) {
            return $this->redirect("home.index");
        }

        if ($this->section->getCategory(Request::input("category")) === null) {
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "move_to_token" => "token"
        ])) {
            $this->post->moveTo($postId, Request::input("category"));
        }

        return $this->redirect("post.slug_index", [
            "sectionName" => $this->section->getSection($this->section->getCategory(Request::input('category'))->parent)->url_name,
            "categoryId" => $this->section->getCategory(Request::input('category'))->url_name,
            "postId" => $postId,
            "postSlugUrl" => SlugUrl::generate($this->post->postGetter($postId)->subject)
        ]);
    }

    public function addSubjectPost ($categoryId) {
        $category = $this->section->getCategory($categoryId);

        if ($category === null) {
            Session::flash("alert_error", "Given category dosen't exists.");
            return $this->redirect("home.index");
        }

        if (!is_null($category->password) &&
            !$this->user->isLoggedToCategory($category->id)) {
            Session::flash("alert_info", trans("auth.category_auth"));
            return $this->redirect("section.login", [
                "sectionName" => $sectionName,
                "categoryId" => $categoryId
            ]);
        }

        if (!Auth::permissions("create_thread")) {
            Session::flash("alert_error", "You can not create new thrade, because you have no permissions to creating threads.");
            return $this->redirect("home.index");
        }

        if (($category->status == 1 
            || $category->status == 2) 
            && !$this->section->checkPermissions($category->id)) {
            Session::flash("alert_error", "You can not write anything because this category is closed.");
            return $this->redirect("home.index");
        }

        if ($this->validation(Request::input(), [
            "title" => "required|str>min:" .
                        Config::get("posting/title/length/min") .
                        "|str>max:" .
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
                "sectionName" => $this->section->getSection($category->parent)->url_name,
                "categoryId" => $category->url_name,
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

        if (!is_null($this->section->getCategory($categoryId)->password) &&
            !$this->user->isLoggedToCategory($categoryId)) {
            Session::flash("alert_info", trans("auth.category_auth"));
            return $this->redirect("section.login", [
                "sectionName" => $sectionName,
                "categoryId" => $categoryId
            ]);
        }

        if (!Auth::permissions("create_thread")) {
            Session::flash("alert_error", "You can not create new thrade, because you have no permissions to creating threads.");
            return $this->redirect("home.index");
        }

        $this->view->section = $this->section->getCategory($categoryId);
        $this->view->sectionName = $this->section->getSection($this->view->section->parent)->name;
        $this->view->render("post.addSubject");

    }

    public function addAnswer ($sectionId, $categoryId, $postId) {
        $error = "";
        $currentCategory = $this->section->getCategory($categoryId);
        $data = $this->post->postGetter($postId);

        if (!Auth::permissions("creating_answers")) {
            $error = "You can not write anything, because you have no permissions to creating answers.";
        }

        if ($data === null) {
            $error = "Thread you are looking doesn't exists!";
        }

        if (!is_null($currentCategory->password) &&
            !$this->user->isLoggedToCategory($currentCategory->id)) {
                Session::flash("alert_info", trans("auth.category_auth"));
                return $this->redirect("section.login", [
                    "sectionName" => $sectionName,
                    "categoryId" => $data->category
                ]);
        }

        if ($this->section->getSection($currentCategory->id)->status == 1 ||
            $data->status == 1 ||
            $this->section->getSection($currentCategory->id)->status == 2) {
                $error = "Thread you are looking is closed!";
        }

        if (strlen($error) > 0 &&
            !$this->section->checkPermissions($currentCategory->id)) {
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

            $this->post->addNew([
                "parent" => $postId,
                "category" => $data->category,
                "user_id" => Auth::data()->id,
                "contents" => strip_tags(Request::input("post"))
            ]);
        }

        return $this->redirect('post.to_post_index', [
            'sectionName' => $sectionId,
            'categoryId' => $categoryId,
            'postId' => $postId,
            'answerId' => "#post"
        ]);

    }

    public function viewIndex ($sectionName, $categoryId, $postId, $postSlugUrl = null) {
        $section = $this->section->getCategory($categoryId);

        if ($section === null) {
            return $this->redirect("home.index");
        }

        $this->view->parent_post = $this->post->postGetter($postId);
        if ($this->view->parent_post !== null) {

            if ($section->status == 2 && !$this->section->checkPermissions($section->id)) {
                return $this->redirect("home.index");
            }

            if (!is_null($section->password) &&
                !$this->user->isLoggedToCategory($section->id)) {
                Session::flash("alert_info", trans("auth.category_auth"));
                return $this->redirect("section.login", [
                    "sectionName" => $sectionName,
                    "categoryId" => $categoryId
                ]);
            }

            $this->view->title = "{$this->view->parent_post->subject} - Forum";
            $this->post->visitIncrement($postId);
            $this->view->postObj = $this->post;
            $this->view->user = $this->user;
            $this->view->vote = new Vote();
            $this->view->reportToken = Token::generate("report_token");
            $this->view->urlToken = Token::generate("url_token");
            $this->view->section_id = $sectionName;
            $this->view->category_id = $categoryId;
            $this->view->hasPermissions = false;
            $this->view->threadBlockedReason = "";
            $this->view->bb = new \BbCode();

            if ($this->section->checkPermissions($section->id)) {
                $this->view->hasPermissions = true;
            }

            /*Checking post status*/

            if (!Auth::check()) {
                $this->view->threadBlockedReason = "You must be logged if you want to write something in this thread.";
            } else if (!Auth()->permissions('creating_answers')) {
                $this->view->threadBlockedReason = "You can not write anything, because you have no permissions to creating answers.";
            } else if ($section->status == 1) {
                $this->view->threadBlockedReason = "You can not write anything, because this category is closed by Moderator or Administrator.";
            } else if ($this->view->parent_post->status == 1) {
                $this->view->threadBlockedReason = "You can not write anything, because this thread is closed.";
            }

        }

        $this->view->render("post.viewIndex");
    }

}