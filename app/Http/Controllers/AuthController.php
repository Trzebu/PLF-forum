<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Libs\Http\Request;
use Libs\Session;
use Libs\Translate;
use Libs\User as Auth;

final class AuthController extends Controller {

    public function changeBaseSettings () {
        $user = new User();

        if (Request::input("email") == Auth::data()->email || empty(Request::input("email"))) {
            if ($this->validation(Request::input(), [
                "old_password" => ["required", "old password"],
                "new_password" => ["required|min_string:5", "new password"],
                "new_password_again" => ["same:new_password", "new password again"],
                "base_settings_token" => "token"
            ])) {
                if (password_verify($password, $db->password)) {

                } else {
                    Session::flash("alert_error", "The password provided is incorrect");
                }
            }

            return $this->redirect("auth.options");
        }

        // if ($this->validation(Request::input(), [

        // ])) {

        // }

    }

    public function viewOptions () {
        $this->view->data = Auth::data();
        $this->view->render("user.options");
    }

    public function indexLogin () {
        $this->view->render("auth.login");
    }

    public function postLogin () {
        
        if ($this->validation(Request::input(), [
            "username" => ["required", Translate::get("auth.inputs.username")],
            "password" => ["required", Translate::get("auth.inputs.password")],
            "_token" => "token",
        ])) {
            if (Auth::login(["username" => Request::input("username"), "email" => Request::input("username")], 
                        Request::input("password"), 
                        Request::input("remember"))) {
                Session::flash("alert_success", Translate::get("auth.login_success"));
                $this->redirect("home.index");
                return;
            } else {
                Session::flash("alert_error", Translate::get("auth.login_fail"));
            }

        }

    $this->redirect("auth.login");
    }

    public function indexRegister () {
        $this->view->render("auth.register");
    }

    public function postRegister () {
        
        if ($this->validation(Request::input(), [
            "username" => ["required|alpha_num|unique:users|min_string:4|max_string:30", Translate::get("auth.inputs.username")],
            "email" => ["required|unique:users|max_string:100", Translate::get("auth.inputs.email")],
            "password" => ["required|min_string:5", Translate::get("auth.inputs.password")],
            "password_again" => ["same:password", Translate::get("auth.inputs.password_again")],
            "_token" => "token" 
        ])) {
            $user = new User();
            $user->create(Request::input());

            Session::flash("alert_success", Translate::get("auth.register_success"));
        }

        $this->redirect("auth.register");
    }

    public function logout () {
        Auth::logout();
        $this->redirect("home.index");
    }

}