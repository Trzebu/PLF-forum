<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Post;
use App\Models\User;
use Libs\Config;
use Libs\Http\Request;
use Libs\Translate;
use Libs\Session;
use Libs\User as Auth;

final class HomeController extends Controller {
    
    public function ipBan () {

        if (!Auth::hasIpBan()) {
            return $this->redirect("home.index");
        }

        $user = new User();
        $this->view->data = $user->ipBanDetails();
        $this->view->user = $user;
        $this->view->render("home.ip_ban");
    }

    public function languageChange () {

        if ($this->validation(Request::input(), [
            "lang_change_token" => "token"
        ])) {
            if (Translate::changeLang(Request::input("lang"))) {
                Session::flash("alert_success", "Language changed successfully.");
            } else {
                Session::flash("alert_info", "Language change error. Contact witch forum administrator.");
            }
        }

        $this->redirect("forum_general_options.view");
    }

    public function viewForumOptions () {
        if (Config::get("page/general_options/hidden")) {
            return $this->redirect("home.index");
        }

        $this->view->lang_packs = [];

        foreach (scandir(__ROOT__ . "/resources/lang") as $lang) {
            if (strpos($lang, ".") === false) {
                $info = include(__ROOT__ . "/resources/lang/{$lang}/info.php");
                $this->view->lang_packs = array_merge($this->view->lang_packs, [$lang => $info["translated_name"]]);
            }
        }

        $this->view->render("home.forum_general_options");
    }

    public function index () {
        $section = new Section();
    
        $this->view->sections = $section->getSections();
        $this->view->section = $section;
        $this->view->postObj = new Post();
        $this->view->user = new User();

        $this->view->render("home.index");
    }

}