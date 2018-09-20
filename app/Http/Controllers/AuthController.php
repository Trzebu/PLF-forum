<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Libs\Http\Request;
use Libs\Session;
use Libs\Translate;
use Libs\User as Auth;

final class AuthController extends Controller {

    public function changeAvatar () {
        //dd(getimagesize ($_FILES['fileToUpload']['tmp_name']));
        // dd($_FILES['image']);
        // dd($_POST);

        if ($this->validation(Request::input(), [
            "image" => "required|image:gif",
            "avatar_change_token" => "token"
        ])) {
            dd("sd");
        }

        return $this->redirect("auth.options");
    }

    public function changeGeneralSettings () {
        if ($this->validation(Request::input(), [
            "full_name" => ["max_string:250", "full name"],
            "city" => "max_string:250",
            "country" => "max_string:250",
            "www" => "max_string:250|url",
            "general_settings_token" => "token"
        ])) {
            $user = new User();
            Session::flash("alert_success", "Your general settings has been successfully changed");
            $user->changeUserSettings([
                "full_name" => Request::input("full_name"),
                "city" => Request::input("city"),
                "country" => Request::input("country"),
                "www" => Request::input("www"),
            ]);
        }

        return $this->redirect("auth.options");
    }

    public function changeBaseSettings () {
        $user = new User();

        if (Request::input("email") != Auth::data()->email && !empty(Request::input("email"))) {
            if ($this->validation(Request::input(), [
                "old_password" => ["required", "old password"],
                "email" => ["required|unique:users|max_string:100", Translate::get("auth.inputs.email")],
                "base_settings_token" => "token"
            ])) {
                if (password_verify(Request::input("old_password"), Auth::data()->password)) {
                    $user->changeUserSettings([
                        "email" => Request::input("email")
                    ]);
                } else {
                    Session::flash("alert_error", "The password provided is incorrect");
                }
            }
        }

        if (!empty(Request::input("new_password"))) {
            if ($this->validation(Request::input(), [
                "old_password" => ["required", "old password"],
                "new_password" => ["required|min_string:5", "new password"],
                "new_password_again" => ["same:new_password", "new password again"],
                "base_settings_token" => "token"
            ])) {
                if (password_verify(Request::input("old_password"), Auth::data()->password)) {
                    $user->changeUserSettings([
                        "password" => password_hash(Request::input("new_password"), PASSWORD_DEFAULT)
                    ]);
                } else {
                    Session::flash("alert_error", "The password provided is incorrect");
                }
            }
        }
        Session::flash("alert_success", "Your base settings has been successfully changed");
        return $this->redirect("auth.options");
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
            "username" => ["required|alpha:num|unique:users|str>min:4>max:30", Translate::get("auth.inputs.username")],
            "email" => ["required|is_valid>email|unique:users|str>max:100", Translate::get("auth.inputs.email")],
            "password" => ["required|str>min:5", Translate::get("auth.inputs.password")],
            "password_again" => ["same:password", Translate::get("auth.inputs.password_again")],
            "rule" => "accepted",
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