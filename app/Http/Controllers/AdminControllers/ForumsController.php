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

    public function deleteCategory ($id, $token) {
        if ($this->section->getSection($id) === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        if (!Token::check("url_token", $token)) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.forums.manage_forums");
        }

        $this->section->deleteCategory($id);

        Session::flash("alert_success", "Categroy has been deleted.");
        $this->redirect("admin.forums.manage_forums");
    }

    public function deleteSection ($id, $token) {
        if ($this->section->getSection($id) === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        if (!Token::check("url_token", $token)) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.forums.manage_forums");
        }

        $this->section->deleteSection($id);

        Session::flash("alert_success", "Section has been deleted.");
        $this->redirect("admin.forums.manage_forums");
    }

    public function newForumPost () {
        if (!$this->validation(Request::input(), [
            "name" => "required|unique:sections",
            "create_forum_token" => "token"
        ])) {
            return $this->redirect("admin.forums.new_forum");
        }

        $password = null;
        $permissions = [];
        $parent = Request::input("parent") == 0 ? null :
                  Request::input("parent");

        if (!empty(Request::input("password"))) {
            if (!$this->validation(Request::input(), [
                "password" => "required",
                "password_again" => ["same:password", "Password again"]
            ])) {
                return $this->redirect("admin.forums.new_forum");
            }

            $password = password_hash(Request::input("password"), PASSWORD_DEFAULT);
        }

        foreach (Request::input("permissions") as $key => $value) {
            if ($value) {
                array_push($permissions, $key);
            }
        }

        $this->section->newRecord([
            "parent" => $parent,
            "queue" => $this->section->highestValueAsQueue($parent) + 1,
            "status" => Request::input("status"),
            "permissions" => implode(",", $permissions),
            "password" => $password,
            "name" => Request::input("name"),
            "url_name" => empty(Request::input("url_name")) ? SlugUrl::generate(Request::input("name")) : Request::input("url_name"),
            "description" => Request::input("forum_description")
        ]);

        Session::flash("alert_success", "Your forum has been created.");

        $this->redirect("admin.forums.manage_forums");
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