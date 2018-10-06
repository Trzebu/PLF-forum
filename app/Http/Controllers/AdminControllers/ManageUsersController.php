<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Section;
use App\Models\AdminModels\UserOptions;
use Libs\Http\Request;
use Libs\Session;
use Libs\Config;
use Libs\Token;
use Libs\User as Auth;

final class ManageUsersController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->user = new User();
        $this->section = new Section();
        $this->userOptions = new UserOptions();
    }

    public function resetWarnings ($id, $token) {
        $data = $this->user->data($id);

        if ($data === null) {
            Session::flash("alert_error", "The requested user does not exist.");
            return $this->redirect("admin.general_settings.manage_users");
        }

        if (!Token::check("reset_warnings_token", $token)) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.general_settings.manage_users.view_user", [
                "id" => $id
            ]);
        }

        $this->user->warnings($id, -$data->warnings);

        Session::flash("alert_success", "Reseted warnings.");
        return $this->redirect("admin.general_settings.manage_users.view_user", [
            "id" => $id
        ]);
    }

    public function addWarnings ($id) {
        $data = $this->user->data($id);

        if ($data === null) {
            Session::flash("alert_error", "The requested user does not exist.");
            return $this->redirect("admin.general_settings.manage_users");
        }

        if (!$this->validation(Request::input(), [
            "add_warning_points_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.general_settings.manage_users.view_user", [
                "id" => $id
            ]);
        }

        $this->user->warnings($id, Request::input("quantity"));

        Session::flash("alert_success", "Added " . Request::input("quantity") . " warning points.");
        return $this->redirect("admin.general_settings.manage_users.view_user", [
            "id" => $id
        ]);
    }

    public function changeRank ($id) {
        $data = $this->user->data($id);

        if ($data === null) {
            Session::flash("alert_error", "The requested user does not exist.");
            return $this->redirect("admin.general_settings.manage_users");
        }

        if (!$this->validation(Request::input(), [
            "change_user_rank_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.general_settings.manage_users.view_user", [
                "id" => $id
            ]);
        }

        $this->user->changeUserSettings($id, [
            "permissions" => Request::input("change_rank")
        ]);

        Session::flash("alert_success", "User rank has been changed.");
        return $this->redirect("admin.general_settings.manage_users.view_user", [
            "id" => $id
        ]);
    }

    public function moveThreads ($id) {
        $data = $this->user->data($id);

        if ($data === null) {
            Session::flash("alert_error", "The requested user does not exist.");
            return $this->redirect("admin.general_settings.manage_users");
        }

        if ($this->section->getCategory(Request::input("move_threads")) === null) {
            Session::flash("alert_info", "Given category dose not exists.");
            return $this->redirect("admin.general_settings.manage_users.view_user", [
                "id" => $id
            ]);
        }

        if (!$this->validation(Request::input(), [
            "move_user_threads_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            return $this->redirect("admin.general_settings.manage_users.view_user", [
                "id" => $id
            ]);
        }

        $this->userOptions->moveThreads($id, Request::input("move_threads"));

        Session::flash("alert_success", "All user threads has been moved to {$this->section->getCategory(Request::input("move_threads"))->name}.");
        return $this->redirect("admin.general_settings.manage_users.view_user", [
            "id" => $id
        ]);
    }

    public function banIp ($id) {
        $data = $this->user->data($id);

        if ($data === null) {
            Session::flash("alert_error", "The requested user does not exist.");
            return $this->redirect("admin.general_settings.manage_users");
        }

        if ($this->userOptions->hasIpBan($data->ip)) {
            Session::flash("alert_success", "IP {$data->ip} has been removed from blocked list.");
            $this->userOptions->removeIpBan($data->ip);
            return $this->redirect("admin.general_settings.manage_users.view_user", [
                "id" => $id
            ]);
        }

        if (!$this->validation(Request::input(), [
            "reason" => "required",
            "ban_ip_token" => "token"
        ])) {
            return $this->redirect("admin.general_settings.manage_users.view_user", [
                "id" => $id
            ]);
        }

        Session::flash("alert_success", "IP {$data->ip} has been added to blocked list.");
        $this->userOptions->giveIpBan($data->ip, Request::input("reason"));

        $this->redirect("admin.general_settings.manage_users.view_user", [
            "id" => $id
        ]);
    }

    public function newPassword ($id) {
        $data = $this->user->data($id);

        if ($data === null) {
            Session::flash("alert_error", "The requested user does not exist.");
            return $this->redirect("admin.general_settings.manage_users");
        }

        if ($this->validation(Request::input(), [
            "password" => ["required|str>min:" .
                            Config::get("user/auth/password/length/min") .
                            ">max:" .
                            Config::get("user/auth/password/length/max"), trans("auth.inputs.password")],
            "password_again" => ["same:password", trans("auth.inputs.password_again")],
            "new_user_password_token" => "token"
        ])) {
            Session::flash("alert_success", "{$data->username} password has been changed.");
            $this->user->changeUserSettings($id, [
                "password" => password_hash(Request::input("password"), PASSWORD_DEFAULT)
            ]);
        } else {
            Session::flash("alert_info", "Nothing has been changed.");
        }

        $this->redirect("admin.general_settings.manage_users.view_user", [
            "id" => $id
        ]);
    }

    public function editBase ($id) {
        $data = $this->user->data($id);
        $rules = ["edit_base_user_settins_token" => "token"];
        $fields = [];

        if ($data === null) {
            Session::flash("alert_error", "The requested user does not exist.");
            return $this->redirect("admin.general_settings.manage_users");
        }

        if (Request::input("username") != $data->username) {
            $rules = array_merge($rules, [
                            "username" => ["required|alpha:num|unique:users|str>min:" . 
                            Config::get("user/auth/username/length/min") . 
                            ">max:" . 
                            Config::get("user/auth/username/length/max"), trans("auth.inputs.username")]
                        ]);
            $fields = array_merge($fields, ["username" => Request::input("username")]);
        }

        if (Request::input("email") != $data->email) {
            $rules = array_merge($rules, [
                            "email" => ["required|is_valid>email|unique:users|str>min:" . 
                            Config::get("user/auth/email/length/min") .
                            ">max:" . 
                            Config::get("user/auth/email/length/max"), trans("auth.inputs.email")]
                        ]);
            $fields = array_merge($fields, ["email" => Request::input("email")]);
        }

        if ($this->validation(Request::input(), $rules)) {
            if (count($fields) > 0) {
                Session::flash("alert_success", "Data has been changed!");
                $this->user->changeUserSettings($id, $fields);
            } else {
                Session::flash("alert_info", "Nothing has been changed.");
            }
        }

        $this->redirect("admin.general_settings.manage_users.view_user", [
            "id" => $id
        ]);
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
        $this->view->section = $this->section;
        $this->view->userOptions = $this->userOptions;
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