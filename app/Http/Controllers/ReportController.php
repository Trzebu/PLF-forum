<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Files;
use App\Models\User;
use App\Models\Report;
use App\Models\Section;
use Libs\User as Auth;
use Libs\Token;
use Libs\Session;
use Libs\Http\Request;
include __ROOT__ . "/libs/Bbcode/BbCode.php";

final class ReportController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->report = new Report();
        $this->user = new User();
    }

    public function changeCaseStatus ($id) {
        if ($this->report->getReport($id) === null) {
            Session::flash("alert_error", "This report dosen't exists.");
            return $this->redirect("report.view");
        }

        if (!$this->report->modHasPermissions($this->report->getReport($id)->content_type, $this->report->getReport($id)->id)) {
            Session::flash("alert_error", "You have no permissions to moderating this report.");
            return $this->redirect("report.view");
        }

        $statuses = trans("report.statuses");

        if (!isset($statuses[Request::input("status")])) {
            Session::flash("alert_error", "This status dosen't exists.");
            return $this->redirect("report.view");
        }
        if ($this->validation(Request::input(), [
            "status_change_token" => "token"
        ])) {
            $this->report->update($id, [
                "status" => Request::input("status")
            ]);
            Session::flash("alert_success", "The case status has been changed.");
        }

        return $this->redirect("report.view");
    }

    public function viewReportByID ($id) {
        $this->view->data = $this->report->getReport($id);
        $this->view->user = $this->user;

        if ($this->view->data === null) {
            Session::flash("alert_error", "This report dosen't exists.");
            return $this->redirect("report.view");
        }

        if (!$this->report->modHasPermissions($this->view->data->content_type, $this->view->data->id)) {
            Session::flash("alert_error", "You have no permissions to moderating this report.");
            return $this->redirect("report.view");
        }

        if ($this->view->data->content_type == "post") {
            $post = new Post();
            $section = new Section();
            $bb = new \BbCode();
            $content = $post->getAnswer($this->view->data->content_id);
            $bb->parse($content->contents, false);
            $this->view->author = $content->user_id;
            $this->view->contentCreatedAt = $content->created_at;

            if (is_null($content->parent)) {
                $this->view->link = route("post.id_index", [
                    "sectionName" => $section->getSectionByCategory($content->category)->id,
                    "categoryId" => $content->category,
                    "postId" => $content->id
                ]);
                $this->view->contents = "<center><h5>Thread - {$content->subject}</h5></center><br>{$bb->getHtml()}";
            } else {
                $this->view->link = route("post.to_post_index", [
                    "sectionName" => $section->getSectionByCategory($content->category)->id,
                    "categoryId" => $content->category,
                    "postId" => $content->parent,
                    "answerId" => "#post_" . $content->id
                ]);
                $this->view->contents = "<center><h5>Post</h5></center><br>{$bb->getHtml()}";
            }

        } else if ($this->view->data->content_type == "file") {
            $file = new Files();
            $this->view->author = $file->getFile($this->view->data->content_id)->user_id;
            $this->view->contentCreatedAt = $file->getFile($this->view->data->content_id)->created_at;
            $this->view->link = route("user_files.view_file", ["fileId" => $this->view->data->content_id]);
            $this->view->contents = "<center><h5>File - {$file->getFile($this->view->data->content_id)->original_name}</h5></center><br>";
        } else if ($this->view->data->content_type == "profile") {
            $this->view->author = $this->view->data->content_id;
            $this->view->contentCreatedAt = $this->view->user->data($this->view->data->content_id)->created_at;
            $this->view->link = route('profile.index_by_id', ["id" => $this->view->data->content_id]);
            $this->view->contents = "<center><h5>Profile - <a href='" . route('profile.index_by_id', ["id" => $this->view->data->content_id]) . "'>{$this->view->user->username($this->view->data->content_id)}</a></h5></center><br>";
        }

        $this->view->render("report.view_report");
    }

    public function viewReports () {
        $this->view->reports = $this->report->getAll();
        $j = count($this->view->reports);

        for ($i = 0; $i < $j; $i++) {
            if (!$this->report->modHasPermissions($this->view->reports[$i]->content_type, $this->view->reports[$i]->content_id)) {
                unset($this->view->reports[$i]);
            }
        }

        $this->view->user = $this->user;
        $this->view->render("report.mods_view");
    }

    public function reportPost ($id, $contentType) {
        if (!Auth::permissions("reporting")) {
            Session::flash("alert_error", "You have no permissions to use reporting.");
            return $this->redirect("home.index");
        }

        $data = null;

        if ($contentType == "post") {
            $post = new Post();
            $data = $post->getAnswer($id);

            if ($data === null) {
                return $this->redirect("home.index");
            }
        } else if ($contentType == "file") {
            $file = new Files();
            $data = $file->getFile($id);

            if ($data === null) {
                return $this->redirect("home.index");
            }
        } else if ($contentType == "profile") {
            $data = $this->user->data($id);

            if ($data === null) {
                return $this->redirect("home.index");
            }
        }

        if ($this->report->isReported($id, $contentType)) {
            Session::flash("alert_info", "This contents is already reported.");
        } else {
            if ($this->validation(Request::input(), [
                "post" => "required|str>min:10>max:2000",
                "post_token" => "token"
            ])) {
                Session::flash("alert_success", "Your report has been sent to verification. You can see report status in your profile.");
                $this->report->new([
                    "user_id" => Auth::data()->id,
                    "content_id" => $data->id,
                    "content_type" => $contentType,
                    "reason" => Request::input("post") 
                ]);
            } else {
                Session::flash("alert_error", "Sorry, but we detect some errors:<br>Reason field is required.<br>Reason field must have 10 characters.<br>Reason field can not have more then 2000 characters.<br>Try again.");
            }
        }

        if ($contentType == "post") {
            $section = new Section();
            return $this->redirect("post.id_index", [
                "sectionName" => $section->getSectionByCategory($post->getAnswer($id)->category)->url_name,
                "categoryId" => $section->getCategory($post->getAnswer($id)->category)->url_name,
                "postId" => $post->getAnswer($id)->parent === null ? $post->getAnswer($id)->id : $post->getAnswer($id)->parent
            ]);
        } else if ($contentType == "file") {
            return $this->redirect("user_files.view_file", [
                "fileId" => $id
            ]);
        } else if ($contentType == "profile") {
            return $this->redirect("profile.index_by_id", [
                "id" => $id
            ]);
        }
    }

    public function report ($id, $contentType, $token) {

        if (!Token::check("report_token", $token)) {
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("reporting")) {
            Session::flash("alert_error", "You have no permissions to use reporting.");
            return $this->redirect("home.index");
        }

        $this->view->user = new User();
        $this->view->contents = $contentType;

        if ($contentType == "post") {
            $post = new Post();
            $data = $post->getAnswer($id);

            if ($data === null) {
                return $this->redirect("home.index");
            }

            $this->view->data = $post->getAnswer($id);
        } else if ($contentType == "file") {
            $file = new Files();
            $data = $file->getFile($id);

            if ($data === null) {
                return $this->redirect("home.index");
            }

            $this->view->data = $file->getFile($id);
        } else if ($contentType == "profile") {
            $data = $this->user->data($id);

            if ($data === null) {
                return $this->redirect("home.index");
            }

            $this->view->data = $user->data($id);
        }

        return $this->view->render("report.contents");
    }

}