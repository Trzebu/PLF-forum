<?php

namespace App\Models\AdminModels;

use Libs\Model;

final class SystemRegistry extends Model {

    protected $_table = "system_registry";

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