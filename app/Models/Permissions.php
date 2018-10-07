<?php

namespace App\Models;

use Libs\Model;
use App\Models\User;

final class Permissions extends Model {

    protected $_table = "permissions";

    public function getRankByPermission ($search) {
        $groups = $this->get()->results();

        for ($i = 0; $i < count($groups); $i++) {
            $keys = json_decode($groups[$i]->permissions);
            foreach ($keys as $key => $value) {
                if ($key == $search && $value) {
                    return $groups[$i];
                }
            }
        }

        return false;
    }

    public function getRank ($name = null) {
        if ($name !== null) {
            $this->where("name", "=", $name);
        }

        return $this->get()->results();
    }

    public function has ($userId, $key = null) {
        $user = new User();
        $groups = $this->where("id", "=", $user->data($userId)->permissions)->get()->first();

        if ($key !== null) {
            $groups = json_decode($groups->permissions, true);
            
            foreach ($groups as $group => $value) {
                if ($group == $key && $value) {
                    return true;
                }
            }

            return false;
        }

        return $groups->name;
    }

}