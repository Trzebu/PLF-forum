<?php

namespace App\Models;
use Libs\Model;

final class Section extends Model {

    protected $_table = "sections";

    public function getCategory ($category_id) {
        return $this->where("id", "=", $category_id)->and("parent", "not_null")->or("url_name", "=", $category_id)->and("parent", "not_null")->get()->count() > 0 ? $this->first() : null;
    }

    public function getSectionCategories ($section_id) {

        $section_id = !is_numeric($section_id) ? $this->getSection($section_id) ? $this->getSection($section_id)->id : 0 : $section_id;

        return $this->where("parent", "=", $section_id)->or("url_name", "=", $section_id)->get()->count() > 0 ? $this->results() : null;

    }

    public function getSection ($section_id) {

        return $this->where("id", "=", $section_id)->or("url_name", "=", $section_id)->get()->count() > 0 ? $this->first() : null;

    }

    public function getSections () {

        return $this->where("parent", "null")->get()->count() > 0 ? $this->results() : null;

    }

}