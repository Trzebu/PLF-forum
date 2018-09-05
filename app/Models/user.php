<?php

namespace App\Models;
use Libs\Model;
use Libs\User as Auth;
use Libs\DataBase\DataBase as DB;

final class User extends Model {
    protected $_table = "users";

    public function getAvatar ($id) {
        return $this->where("id", "=", $id)->get(["avatar"])->count() > 0 ? route('/') . "/" . $this->first()->avatar : route('/') .  "/public/app/uploaded_images/man.jpg";
    }

    public function permissions ($id) {
        $permissions = $this->where("id", "=", $id)->get(["permissions"])->first()->permissions;

        if (count($permissions) > 0) {
            return DB::instance()->table("permissions")->where("id", "=", $permissions)->get(["name", "color"])->first();
        }

        return null;
    }

    public function username ($id = null) {
        if ($id !== null) {
            return "<font color='{$this->permissions($id)->color}' title='{$this->permissions($id)->name}'>" . $this->where("id", "=", $id)->get(["username"])->first()->username . "</font>";
        }
        return Auth::data()->nick;
    }

    public function create ($inputs) {

        $this->insert([
            "username" => $inputs["username"],
            "email" => $inputs["email"],
            "password" => password_hash($inputs["password"], PASSWORD_DEFAULT)
        ]);

    }

}