<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Libs\Http\Request;
use Libs\Session;
use Libs\User as Auth;
use Libs\Token;
use Libs\Config;

final class AuthController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->user = new User();
    }

    public function signature () {

        if (!Auth::permissions("signature")) {
            Session::flash("alert_error", "You have no permissions to use signature.");
            return $this->redirect("auth.options");
        }

        if ($this->validation(Request::input(), [
            "post" => ["required|str>min:" .
                        Config::get("user/auth/signature/length/min") .
                        ">max:" .
                        Config::get("user/auth/signature/length/max"), "signature"],
            "signature_user_token" => "token"
        ])) {
            Session::flash("alert_success", "Your signature was saved.");
            $this->user->changeUserSettings([
                "signature" => Request::input("post")
            ]);
        }

        return $this->redirect("auth.options");
    }

    public function aboutUser () {

        if ($this->validation(Request::input(), [
            "post" => ["required|str>min:" .
                        Config::get("user/auth/about/contents/length/min") .
                        ">max:" .
                        Config::get("user/auth/about/contents/length/max"), "about"],
            "about_user_token" => "token"
        ])) {
            Session::flash("alert_success", "Your about information was saved.");
            $this->user->changeUserSettings([
                "about" => Request::input("post")
            ]);
        }

        return $this->redirect("auth.options");
    }

    public function disableAvatar ($token) {

        if (!Token::check("disable_avatar", $token)) {
            return $this->redirect("auth.options");
        }
 
        $this->user->changeUserSettings([
            "avatar" => 0
        ]);

        Session::flash("alert_success", "Your avatar has been disabled.");
        return $this->redirect("auth.options");
    }

    public function changeGeneralSettings () {
        if ($this->validation(Request::input(), [
            "full_name" => ["str>max:" . Config::get("user/auth/additional/full_name/length/max"), "full name"],
            "city" => "str>max:" . Config::get("user/auth/additional/city/length/max"),
            "country" => "str>max:" . Config::get("user/auth/additional/country/length/max"),
            "www" => "str>max:" . Config::get("user/auth/additional/www/length/max") . "|is_valid>url",
            "general_settings_token" => "token"
        ])) {
            Session::flash("alert_success", "Your general settings has been successfully changed");
            $this->user->changeUserSettings([
                "full_name" => Request::input("full_name"),
                "city" => Request::input("city"),
                "country" => Request::input("country"),
                "www" => Request::input("www"),
            ]);
        }

        return $this->redirect("auth.options");
    }

    public function changeBaseSettings () {

        if (Request::input("email") != Auth::data()->email && !empty(Request::input("email"))) {
            if ($this->validation(Request::input(), [
                "old_password" => ["required", "old password"],
                "email" => ["required|is_valid>email|unique:users|str>min:" . 
                            Config::get("user/auth/email/length/min") .
                            ">max:" . 
                            Config::get("user/auth/email/length/max"), trans("auth.inputs.email")],
                "base_settings_token" => "token"
            ])) {
                if (password_verify(Request::input("old_password"), Auth::data()->password)) {
                    $this->user->changeUserSettings([
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
                "new_password" => ["required|str>min:" .
                                    Config::get("user/auth/password/length/min") .
                                    ">max:" .
                                    Config::get("user/auth/password/length/max"), trans("auth.inputs.password")],
                "new_password_again" => ["same:new_password", "new password again"],
                "base_settings_token" => "token"
            ])) {
                if (password_verify(Request::input("old_password"), Auth::data()->password)) {
                    $this->user->changeUserSettings([
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
            "username" => ["required", trans("auth.inputs.username")],
            "password" => ["required", trans("auth.inputs.password")],
            "_token" => "token",
        ])) {
            if (Auth::login(["username" => Request::input("username"), "email" => Request::input("username")], 
                        Request::input("password"), 
                        Request::input("remember"))) {
                Session::flash("alert_success", trans("auth.login_success"));
                $this->redirect("home.index");
                return;
            } else {
                Session::flash("alert_error", trans("auth.login_fail"));
            }

        }

    $this->redirect("auth.login");
    }

    public function indexRegister () {
        $this->view->render("auth.register");
    }

    public function postRegister () {
        
        if ($this->validation(Request::input(), [
            "username" => ["required|alpha:num|unique:users|str>min:" . 
                            Config::get("user/auth/username/length/min") . 
                            ">max:" . 
                            Config::get("user/auth/username/length/max"), trans("auth.inputs.username")],
            "email" => ["required|is_valid>email|unique:users|str>min:" . 
                            Config::get("user/auth/email/length/min") .
                            ">max:" . 
                            Config::get("user/auth/email/length/max"), trans("auth.inputs.email")],
            "password" => ["required|str>min:" .
                            Config::get("user/auth/password/length/min") .
                            ">max:" .
                            Config::get("user/auth/password/length/max"), trans("auth.inputs.password")],
            "password_again" => ["same:password", trans("auth.inputs.password_again")],
            "rule" => "accepted",
            "_token" => "token"
        ])) {
            $this->user->create(Request::input());

            Session::flash("alert_success", trans("auth.register_success"));
        }

        $this->redirect("auth.register");
    }

    public function logout () {
        Auth::logout();
        $this->redirect("home.index");
    }

}