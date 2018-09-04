<?php

namespace App\Models;
use Libs\Model;
use Libs\User as Auth;

final class User extends Model {
    protected $_table = "users";

    public function username ($id = null) {
        if ($id !== null) {
            return $this->where("id", "=", $id)->get(["username"])->first()->username;
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