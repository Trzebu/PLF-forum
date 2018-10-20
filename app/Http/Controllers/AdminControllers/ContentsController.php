<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Libs\Http\Request;
use Libs\Session;
use Libs\Config;

final class ContentsController extends Controller {

    public function moderationSet () {
        if (!$this->validation(Request::input(), [
            "moderation_settings_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.contents.moderation");
        }

        Config::edit("report/case/response/contents/bbcode", Request::input("bbcode_case_response"));
        Config::edit("report/case/response/contents/smilies", Request::input("smilies_case_response"));
        Config::edit("report/case/response/contents/length/min", Request::input("min_characters_response_case"));
        Config::edit("report/case/response/contents/length/max", Request::input("max_characters_response_case"));
        Config::edit("report/report_contents/contents/length/min", Request::input("min_characters_report"));
        Config::edit("report/report_contents/contents/length/max", Request::input("max_characters_report"));

        Session::flash("alert_info", "Changes has been sets.");
        $this->redirect("admin.contents.moderation");
    }

    public function moderation () {
        $this->view->render("admin.contents.moderation.settings");
    }

    public function privateMessagesSent () {
        if (!$this->validation(Request::input(), [
            "private_messages_settings_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.contents.private_messages");
        }

        Config::edit("private_message/contents/bbcode", Request::input("bbcode"));
        Config::edit("private_message/contents/smilies", Request::input("smilies"));
        Config::edit("private_message/contents/length/min", Request::input("min_characters_private_messages"));
        Config::edit("private_message/contents/length/max", Request::input("max_characters_pm"));

        Session::flash("alert_info", "Changes has been sets.");
        $this->redirect("admin.contents.private_messages");
    }

    public function privateMessages () {
        $this->view->render("admin.contents.private_messages.settings");
    }

    public function threadsSet () {
        if (!$this->validation(Request::input(), [
            "threads_settings_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.contents.threads");
        }

        Config::edit("posting/bbcode", Request::input("bbcode"));
        Config::edit("posting/smilies", Request::input("smilies"));
        Config::edit("posting/title/length/min", Request::input("min_characters_title_answer"));
        Config::edit("posting/title/length/max", Request::input("max_characters_title_answer"));
        Config::edit("posting/contents/length/min", Request::input("min_characters_answer"));
        Config::edit("posting/contents/length/max", Request::input("max_characters_answer"));

        Session::flash("alert_info", "Changes has been sets.");
        $this->redirect("admin.contents.threads");
    }

    public function threads () {
        $this->view->render("admin.contents.threads.settings");
    }

    public function postingSet () {
        if (!$this->validation(Request::input(), [
            "posting_settings_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.contents.posting");
        }

        Config::edit("posting/answers/bbcode", Request::input("bbcode"));
        Config::edit("posting/answers/smilies", Request::input("smilies"));
        Config::edit("posting/answers/contents/length/min", Request::input("min_characters_answer"));
        Config::edit("posting/answers/contents/length/max", Request::input("max_characters_answer"));

        Session::flash("alert_info", "Changes has been sets.");
        $this->redirect("admin.contents.posting");
    }

    public function posting () {
        $this->view->render("admin.contents.posting.settings");
    }

    public function view () {
        $this->view->render("admin.contents.index");
    }

}