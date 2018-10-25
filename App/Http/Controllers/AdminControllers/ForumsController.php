<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Permissions;
use App\Models\Post;
use Libs\Session;
use Libs\Token;
use Libs\Config;
use Libs\Http\Request;
use Libs\tools\SlugUrl;

final class ForumsController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->section = new Section();
        $this->post = new Post();
    }

    public function settingsSet () {
        if (!$this->validation(Request::input(), [
            "forums_settings_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.forums.settings.set");
        }

        Config::edit("category/view/post/per_page", Request::input("threads_per_page"));
        Config::edit("post/answers/per_page", Request::input("posts_per_page"));
        Config::edit("posting/voting/max_votes_per_post", Request::input("max_votes_per_page"));
        Config::edit("posting/voting/min_votes_per_post", Request::input("min_votes_per_page"));

        Session::flash("alert_info", "Changes has been sets.");
        $this->redirect("admin.forums.settings.set");
    }

    public function settingsView () {
        $this->view->render("admin.forums.general_settings");
    }

    public function deleteCategoriesFromSection ($id, $token) {
        if (!Token::check("delete_categories_section_token", $token)) {
            return $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
        }

        if ($this->section->getSection($id) === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        $this->section->deleteCategoriesFromSection($id);

        Session::flash("alert_success", "All categories was deleted from this section.");
        $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
    }

    public function deletePostsFromCategory ($id, $token) {
        if (!Token::check("delete_posts_category_token", $token)) {
            return $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
        }

        if ($this->section->getCategory($id) === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        $this->post->deleteThreadsByCategory($id);

        Session::flash("alert_success", "All posts was deleted from this category.");
        $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
    }

    public function movePosts ($id) {
        if (!$this->validation(Request::input(), [
            "move_posts_token" => "token"
        ])) {
            return $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
        }

        if ($this->section->getCategory($id) === null ||
            $this->section->getCategory(Request::input("move_posts")) === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        $this->post->movePostsTo($id, Request::input("move_posts"));

        Session::flash("alert_success", "Posts moved.");
        $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
    }

    public function moveCategories ($id) {
        $data = $this->section->getSection($id) === null ?
                $this->section->getCategory($id) :
                $this->section->getSection($id);

        if ($data === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        if (!$this->validation(Request::input(), [
            "move_categories_token" => "token"
        ])) {
            return $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
        }

        if (is_null($data->parent)) {
            $this->section->moveCategories($id, Request::input("new_category"));
        } else {
            $this->section->moveCategory($id, Request::input("new_category"));
        }

        Session::flash("alert_success", "Categories moved.");
        $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
    }

    public function resetPassword ($id, $token) {
        $data = $this->section->getSection($id) === null ?
                $this->section->getCategory($id) :
                $this->section->getSection($id);

        if ($data === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        if (!Token::check("reset_password_token", $token)) {
            return $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
        }

        $this->section->sectionUpdate($id, [
            "password" => null
        ]);

        Session::flash("alert_success", "Password reseted.");
        return $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
    }

    public function forumOptionsSave ($id) {
        $data = $this->section->getSection($id) === null ?
                $this->section->getCategory($id) :
                $this->section->getSection($id);

        if ($data === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        $permissions = [];
        $password = $data->password;
        $parent = is_null($data->parent) ||
                  Request::input("parent") == 0 ? null :
                  Request::input("parent");
        $url_name = Request::input("name") == $data->name ?
                    SlugUrl::generate(Request::input("url_name")) :
                    SlugUrl::generate(Request::input("name"));

        if (!$this->validation(Request::input(), [
            "name" => "required",
            "edit_forum_token" => "token"
        ])) {
            return $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
        }

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

        $this->section->sectionUpdate($id, [
            "parent" => $parent,
            "status" => Request::input("status"),
            "permissions" => implode(",", $permissions),
            "password" => $password,
            "name" => Request::input("name"),
            "url_name" => $url_name,
            "description" => Request::input("forum_description")
        ]);

        Session::flash("alert_success", "Changes was saved.");
        $this->redirect("admin.forums.manage_forums.options", ["id" => $id]);
    }

    public function forumOptions ($id) {
        $this->view->data = $this->section->getSection($id) === null ?
                            $this->section->getCategory($id) :
                            $this->section->getSection($id);
        $this->view->section = $this->section;
        $this->view->permissions = new Permissions();

        if ($this->view->data === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        $this->view->forum_permissions = explode(",", $this->view->data->permissions);
        $this->view->render("admin.forums.manage_forums.options");
    }

    public function deleteCategory ($id, $token) {
        if ($this->section->getSection($id) === null) {
            Session::flash("alert_error", "This forum dosen't exists!");
            return $this->redirect("admin.forums.manage_forums");
        }

        if (!Token::check("delete_category_token", $token)) {
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

        if (!Token::check("delete_section_token", $token)) {
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

    public function newForum ($sectionId = null) {
        $this->view->name = trans("general.without_name");
        $this->view->sectionId = $sectionId;
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