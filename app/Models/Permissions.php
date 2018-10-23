<?php

namespace App\Models;

use Libs\Model;
use App\Models\User;

final class Permissions extends Model {

    protected $_table = "permissions";

    public function deleteGroup ($id) {
        return $this->where("id", "=", $id)
                    ->delete();
    }

    public function addNewPermission ($fields) {
        return $this->insert($fields);
    }

    public function editPermission ($id, $fields) {
        return $this->where("id", "=", $id)
                    ->update($fields);
    }

    public function translated ($userId = null, $search = null) {
        $user = new User();
        $perms = $userId !== null ?
                 $this->where("id", "=", $user->data($userId)->permissions)->get(["permissions"])->first() :
                 $this->rowsLimit(1)->get(["permissions"])->first();
        $translated = [];         

        foreach (json_decode($perms->permissions) as $key => $value) {
            if ($userId !== null) {
                if (!$value) {
                    continue;
                }
            }

            $translated = array_merge($translated, [$key => is_array(trans("permissions." . $key)) ?: trans("permissions." . $key)]);

            if ($key == $search) {
                return [$key => is_array(trans("permissions." . $key)) ?: trans("permissions." . $key)];
            }
        }

        return $translated;
    }

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
            $this->where("id", "=", $name)->or("name", "=", $name);
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