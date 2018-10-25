<?php

namespace App\Models\AdminModels;

use Libs\Model;

final class SystemRegistry extends Model {

    protected $_table = "system_registry";

    public function valueType ($type, $value) {
        switch ($type) {
            case 'int': return (bool) is_numeric($value); break;
            case 'str': return (bool) is_string($value); break;
            case 'bool': return $value == "true" || $value == "false" ? true : false; break;
            case 'json':
                json_decode($value);
                return (bool) json_last_error() === JSON_ERROR_NONE;
            break;
            case 'uns': return (bool) $value === null; break;
        }
    }

    public function registerRemove ($id) {
        $this->where("id", "=", $id)
            ->delete();
    }

    public function editRegistry ($id, $fields) {
        $this->where("id", "=", $id)
            ->update($fields);
    }

    public function getRegistry ($id) {
        return $this->where("id", "=", $id)
                    ->get()
                    ->count() > 0 ? $this->first() : (unset) null;
    }

    public function addNew ($fields) {
        return $this->insert($fields)->lastInsertedID();
    }

    public function permissions ($perm, $name) {
        if ($name == "reading") {
            return (bool) $perm[0] == 1;
        } else if ($name == "edit_value") {
            return (bool) $perm[1] == 1;
        } else if ($name == "edit_reg") {
            return (bool) $perm[2] == 1;
        }
    }

    public function getAllRegistry () {
        return $this->get()->results();
    }

}