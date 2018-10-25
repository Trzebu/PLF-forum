<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Libs\Http\Request;
use Libs\Session;
use Libs\Config;

final class ContentsController extends Controller {

    public function authenticationSet () {
        if (!$this->validation(Request::input(), [
            "authentication_settings_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.contents.authentication");
        }

        Config::edit("user/auth/about/contents/bbcode", Request::input("bbcode_about"));
        Config::edit("user/auth/about/contents/smilies", Request::input("smilies_about"));
        Config::edit("user/auth/signature/contents/bbcode", Request::input("bbcode_signature"));
        Config::edit("user/auth/signature/contents/smilies", Request::input("smilies_signature"));
        Config::edit("user/auth/about/contents/length/min", Request::input("min_about"));
        Config::edit("user/auth/about/contents/length/max", Request::input("max_about"));
        Config::edit("user/auth/signature/length/min", Request::input("min_signature"));
        Config::edit("user/auth/signature/length/max", Request::input("max_signature"));
        Config::edit("user/auth/additional/city/length/max", Request::input("max_city"));
        Config::edit("user/auth/additional/country/length/max", Request::input("max_country"));
        Config::edit("user/auth/additional/full_name/length/max", Request::input("max_full_name"));
        Config::edit("user/auth/additional/www/length/max", Request::input("max_www"));
        Config::edit("user/auth/email/length/min", Request::input("min_email"));
        Config::edit("user/auth/email/length/max", Request::input("max_email"));
        Config::edit("user/auth/password/length/min", Request::input("min_password"));
        Config::edit("user/auth/password/length/max", Request::input("max_password"));
        Config::edit("user/auth/username/length/min", Request::input("min_username"));
        Config::edit("user/auth/username/length/max", Request::input("max_username"));

        Session::flash("alert_info", "Changes has been sets.");
        $this->redirect("admin.contents.authentication");
    }

    public function avatarSet () {
        if (!$this->validation(Request::input(), [
            "avatar_settings_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.contents.downloads.avatar");
        }

        Config::edit("avatar/default", Request::input("default_avatar"));
        Config::edit("avatar/use_gravatar", Request::input("gravatar"));
        Config::edit("avatar/height/min", Request::input("min_avatar_height"));
        Config::edit("avatar/height/max", Request::input("max_avatar_hegiht"));
        Config::edit("avatar/width/min", Request::input("min_avatar_width"));
        Config::edit("avatar/width/max", Request::input("max_avatar_width"));
        Config::edit("avatar/size/min", Request::input("min_avatar_size"));
        Config::edit("avatar/size/max", Request::input("max_avatar_size"));

        Session::flash("alert_info", "Changes has been sets.");
        $this->redirect("admin.contents.downloads.avatar");
    }

    public function downloadsSet () {
        if (!$this->validation(Request::input(), [
            "uploading_settings_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.contents.downloads.settings");
        }

        Config::edit("uploading/upload_dir", Request::input("uploaded_dir"));
        Config::edit("uploading/size/min", Request::input("min_file_size"));
        Config::edit("uploading/size/max", Request::input("max_file_size"));

        Session::flash("alert_info", "Changes has been sets.");
        $this->redirect("admin.contents.downloads.settings");
    }

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

    public function authentication () {
        $this->view->render("admin.contents.auth.settings");
    }

    public function avatar () {
        $this->view->render("admin.contents.download.user_avatar");
    }

    public function downloads () {
        $this->view->render("admin.contents.download.settings");
    }

    public function moderation () {
        $this->view->render("admin.contents.moderation.settings");
    }

    public function privateMessages () {
        $this->view->render("admin.contents.private_messages.settings");
    }

    public function threads () {
        $this->view->render("admin.contents.threads.settings");
    }

    public function posting () {
        $this->view->render("admin.contents.posting.settings");
    }

    public function view () {
        $this->view->render("admin.contents.index");
    }

}