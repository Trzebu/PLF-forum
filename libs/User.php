<?php

namespace Libs;
use Libs\Session;
use Libs\DataBase\DataBase;
use Libs\Cookie;

class User {

    private static $_data = null;

    public function __construct () {
        if (!Session::exists("u_id")) {
            if (Cookie::exists("remember_token")) {
                $token = DataBase::instance()->table("users")->where("remember_me", "=", Cookie::get("remember_token"))->get(["id"]);
                if ($token->count() > 0) {
                    Session::set("u_id", $token->first()->id);
                }
            }
        }
    }

    public function permissions ($key = null) {
        $groups = DataBase::instance()->table("permissions")->where("id", "=", self::data()->permissions)->get()->first();

        if ($key !== null) {
            $groups = json_decode($groups->permissions, true);
            
            foreach ($groups as $group => $value) {
                if ($group == $key) {
                    if ($value) {
                        return true;
                    }
                }
            }

            return false;
        }

        return $groups->name;
    }

    public function logout () {
        Session::unset("u_id");
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
                $db->and($key, "=", $value);
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

            Cookie::put("remember_token", $token, 2592000);

        }

        Session::set("u_id", $db->id);
        return true;

    }

    public function data () {
        if (self::check()) {
            if (self::$_data === null) {
                self::$_data = DataBase::instance()->table("users")->where("id", "=", Session::get("u_id"))->get()->first();
            }
            return self::$_data;
        }
    }

    public function check () {
        return (bool) Session::exists("u_id");
    }

}