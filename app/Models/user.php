<?php

namespace App\Models;
use Libs\Model;
use Libs\User as Auth;
use Libs\DataBase\DataBase as DB;
use Libs\Config;
use Libs\Http\Request;

final class User extends Model {
    protected $_table = "users";

    public function getUsersByGroup ($id) {
        return $this->where("permissions", "=", $id)
                    ->orderBy(["created_at"])
                    ->paginate(Config::get("profile/users_list/pera_page"))
                    ->get(["id", "username"])
                    ->count() > 0 ? $this->results() : null;
    }

    public function getByPermission ($permission) {
        $groups = DB::instance()->table("permissions")->get()->results();
        $groupsIds = [];

        foreach ($groups as $group) {
            $permits = json_decode($group->permissions);

            if (isset($permits->$permission)) {
                if ($permits->$permission == 1) {
                    array_push($groupsIds, $group->id);
                }
            }
        }

        $this->where("permissions", "=", $groupsIds[0]);
        array_shift($groupsIds);

        foreach ($groupsIds as $id) {
            $this->or("permissions", "=", $id);
        }
        
        return $this->get(["id"])->results();
    }

    public function changeUserSettings ($fields) {
        $this->where("id", "=", Auth::data()->id)
            ->update($fields);
    }

    public function online ($time) {

        if ($this->calcTimeDiff($time) > 30) {
            return (string) "Last visit: {$this->diffToHuman($time)}";
        }

        return (string) '<font color="green">Online</font>';
    }

    public function getUsers () {
        return $this->orderBy(["created_at"])
                    ->paginate(Config::get("profile/users_list/pera_page"))
                    ->get(["id", "username"])
                    ->count() > 0 ? $this->results() : null;
    }

    public function calcGivenVotes ($id) {
        return DB::instance()->table('votes')->where("user_id", "=", $id)->numRow();
    }

    public function data ($id) {
        return $this->where("id", "=", $id)
                    ->or("username", "=", $id)
                    ->or("email", "=", $id)
                    ->get()
                    ->count() > 0 ? $this->first() : null;
    }

    public function getLastTenRegisteredAccounts () {
        $usernameColor = [];
        $users = $this->orderBy(["id"])
                    ->rowsLimit(Config::get("stats/last_ten_registered_accounts"))
                    ->get(["id"])
                    ->count() > 0 ? $this->results() : null;

        foreach ($users as $user) {
            array_push($usernameColor, [
                "username" => $this->username($user->id),
                "id" => $user->id
            ]);
        }

        return $usernameColor;

    }

    public function accountsCount () {
        return $this->numRow();
    }

    public function calcPosts ($id) {
        return DB::instance()->table("posts")->where("user_id", "=", $id)->numRow();
    }

    public function calcReputation ($id) {
        $amount = 0;
        $votes = DB::instance()->table("votes")->where("rated_user_id", "=", $id)->get(["type"])->results();

        foreach ($votes as $vote) {
            if ($vote->type == 1) {
                $amount++;
            } else {
                $amount--;
            }
        }

        return $amount;
    }

    public function getAvatar ($id, $size = 100) {
        $md = md5($this->where("id", "=", $id)->get(["email"])->first()->email);
        $path = DB::instance()
                    ->table("users_files")
                    ->where("id", "=", $this->where("id", "=", $id)->get(["avatar"])->first()->avatar)
                    ->get(["path"]);
        $path = $path->count() > 0 ? $path->first()->path : null;

        return  $path !== null ? route("/") . Config::get("uploading/upload_dir") . "/" . $path : "https://www.gravatar.com/avatar/{$md}?s={$size}";
    }

    public function allPermissions ($id) {
        $permissions = $this->where("id", "=", $id)->get(["permissions"])->first()->permissions;
        $hasPermissions = [];
        $groups = DB::instance()->table("permissions")->where("id", "=", $permissions)->get(["permissions"])->first()->permissions;
        $groups = json_decode($groups);

        foreach ($groups as $key => $value) {

            if ($value == 1) {
                array_push($hasPermissions, $key);
            }

        }

        return $hasPermissions;
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
            "password" => password_hash($inputs["password"], PASSWORD_DEFAULT),
            "ip" => Request::clientIP()
        ]);

    }

}