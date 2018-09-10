<?php

namespace App\Models;
use Libs\Model;
use Libs\User as Auth;
use Libs\DataBase\DataBase as DB;

final class User extends Model {
    protected $_table = "users";

    public function calcPosts ($id) {
        return DB::instance()->table("posts")->where("user_id", "=", $id)->numRow();
    }

    public function calcReputation ($id) {
        $amount = 0;
        $posts = DB::instance()->table("posts")->where("user_id", "=", $id)->numRow() > 0 ? DB::instance()->table("posts")->where("user_id", "=", $id)->get(["id"])->results() : null;

        if ($posts !== null) {
            foreach ($posts as $post) {
                $votes = DB::instance()->table("votes")->where("post_id", "=", $post->id)->numRow() > 0 ? DB::instance()->table("votes")->where("post_id", "=", $post->id)->get(["type"])->results() : null;

                if ($votes !== null) {
                    foreach ($votes as $vote) {
                        if ($vote->type == 1) {
                            $amount++;
                        } else {
                            $amount--;
                        }
                    }
                }

            }
        }

        return $amount;
    }

    public function getAvatar ($id, $size = 100) {
        $md = md5($this->where("id", "=", $id)->get(["email"])->first()->email);
        return  strlen($this->where("id", "=", $id)->get(["avatar"])->first()->avatar) > 0 ? $this->first()->avatar : "https://www.gravatar.com/avatar/{$md}?s={$size}";
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