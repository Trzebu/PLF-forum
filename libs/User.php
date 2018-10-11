<?php

namespace Libs;

use App\Models\Permissions;
use Libs\Session;
use Libs\DataBase\DataBase;
use Libs\Cookie;
use Libs\Config;
use Libs\Http\Request;
use Libs\Http\Redirect;
use App\Models\PrivateMessage;

class User {

    private static $_data = null;

    public function __construct () {
        self::hasIpBan();
        if (!self::check()) {
            if (Cookie::exists("remember_token")) {
                $token = DataBase::instance()
                                    ->table("users")
                                    ->where("remember_me", "=", Cookie::get("remember_token"))
                                    ->get(["id"]);
                if ($token->count() > 0) {
                    Session::set("u_id", $token->first()->id);
                }
            }
        } else {
            if (!self::permissions("log_in")) {
                Session::flash("alert_info", "You have no permission to logged in.");
                self::logout();
            }
        }
    }

    public function hasIpBan () {
        if (DataBase::instance()->table("ip_bans")->where("ip", "=", Request::clientIP())->numRow() > 0) {
            if (!Request::inUrl("ip_ban")) {
                Redirect::to("home.ip_ban");
                exit();
            }
        }
    }

    public function getterToUnreadedMessages () {
        $message = new PrivateMessage();
        return $message->getUnreadedMessagesAmount();
    }

    public function avatar ($size = 75) {
        $md = md5(self::data()->email);
        $path = DataBase::instance()
                    ->table("users_files")
                    ->where("id", "=", self::data()->avatar)
                    ->get(["path"]);
        $path = $path->count() > 0 ? $path->first()->path : null;
        $gravatar = Config::get("avatar/use_gravatar") ? "https://www.gravatar.com/avatar/{$md}?s={$size}" : route('/') . Config::get("avatar/default");

        return $path !== null ? route("/") . Config::get("uploading/upload_dir") . "/" . $path : $gravatar;
    }

    public function permissions ($key = null) {
        if (!self::check()) {
            return false;
        }
        
        $permission = new Permissions();
        return $permission->has(self::data()->id, $key);
    }

    public function logout () {
        Session::destroy();
        Cookie::delete("remember_token");
        return true;
    }

    public function login ($fields, $password = null, $remember = null) {
        $db = DataBase::instance()->table("users");
        $i = 0;

        foreach ($fields as $key => $value) {
            if ($i == 0) {
                $db->where($key, "=", $value);
            } else {
                $db->or($key, "=", $value);
            }
            $i++;
        }

        if ($db->get()->count() == 0) {
            return false;
        }

        $db = $db->first();

        if ($password !== null) {
            if (!password_verify($password, $db->password)) {
                return false;
            }
        }

        if ($remember !== null) {
            $token = md5(uniqid());

            DataBase::instance()->table("users")->where("id", "=", $db->id)->update([
                "remember_me" => $token
            ]);

            Cookie::put("remember_token", $token, Config::get("user/auth/remember_me/cookie_expiry"));
        }

        Session::set("u_id", $db->id);
        return true;

    }

    public function data () {
        if (self::check()) {
            if (self::$_data === null) {
                $db = DataBase::instance()->table("users");
                self::$_data = $db->where("id", "=", Session::get("u_id"))->get()->first();
                $db->where("id", "=", Session::get("u_id"))->update([
                    "updated_at" => date("Y-m-d H:i:s")
                ]);
            }
            return self::$_data;
        }
    }

    public function check () {
        return (bool) Session::exists("u_id");
    }

}