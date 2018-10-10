<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Permissions;
use Libs\Session;
use Libs\Token;
use Libs\Http\Request;
use Libs\tools\SlugUrl;

final class ForumsController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->section = new Section();
    }

    public function newForumPost () {
        if (!$this->validation(Request::input(), [
            "name" => "required|unique:sections",
            "create_forum_token" => "token"
        ])) {
            return $this->redirect("admin.forums.new_forum");
        }
    }

    public function newForum () {
        $this->view->name = trans("general.without_name");
        if (!empty(Request::urlVar("name"))) {
            $this->view->name = Request::urlVar("name");
        }

        $this->view->permissions = new Permissions();
        $this->view->section = $this->section;
        $this->view->render("admin.forums.new_forum.index");
    }

    public function sectionQueue ($dir, $id, $token) {
        if ($this->section->getSection($id) === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        if (!Token::check("url_token", $token)) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.forums.manage_forums");
        }

        $this->section->changeQueue($id, $dir);
        return $this->redirect("admin.forums.manage_forums");
    }

    public function manageForums () {
        $this->view->section = $this->section;
        $this->view->url_token = token("url_token");
        $this->view->render("admin.forums.manage_forums.manage");
    }

    public function redirectToManageForums () {
        $this->redirect("admin.forums.manage_forums");
    }

}