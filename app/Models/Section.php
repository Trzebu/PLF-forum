<?php

namespace App\Models;
use Libs\Model;

final class Section extends Model {

    protected $_table = "sections";

    public function getSectionCategories ($section_id) {

        return $this->where("parent", "=", $section_id)->get()->count() > 0 ? $this->results() : null;

    }

    public function getSections () {

        return $this->where("parent", "null")->get()->count() > 0 ? $this->results() : null;

    }

}