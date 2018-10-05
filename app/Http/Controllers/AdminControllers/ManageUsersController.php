<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Libs\Http\Request;
use Libs\Session;
use Libs\Config;
use Libs\Token;

final class ManageUsersController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->user = new User();
    }

    public function viewUser ($id) {
        $user = $this->user->data($id);

        if ($user === null) {
            Session::flash("alert_error", "The requested user does not exist.");
            return $this->redirect("admin.general_settings.manage_users");
        }

        $this->view->title = "ACP :: {$user->username} manage";
        $this->view->data = $user;
        $this->view->user = $this->user;
        $this->view->render("admin.general.manage_users.user");
    }

    public function find () {
        if ($this->user->data(Request::input("userID")) === null) {
            Session::flash("alert_error", "The requested user does not exist.");
            return $this->redirect("admin.general_settings.manage_users");
        }

        $this->redirect("admin.general_settings.manage_users.view_user", [
            "id" => $this->user->data(Request::input("userID"))->id
        ]);
    }

    public function view () {
        $this->view->render("admin.general.manage_users.view");
    }

}