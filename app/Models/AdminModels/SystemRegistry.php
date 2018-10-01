<?php

namespace App\Models\AdminModels;

use Libs\Model;

final class SystemRegistry extends Model {

    protected $_table = "system_registry";

    public function getAllRegistry () {
        return $this->get()->results();
    }

}