<?php

namespace App\Models;
use Libs\Model;
use Libs\User as Auth;
use Libs\DataBase\DataBase as DB;

final class Section extends Model {

    protected $_table = "sections";

    public function getAllCategories () {
        return $this->where("parent", "not_null")->get(["id", "name"])->results();
    }

    public function getSectionModerators ($sectionId) {

        $permits = $this->where("id", "=", $sectionId)->get(["permissions"])->count() > 0 ? $this->first() : null;
        $moderators = [];

        if ($permits !== null) {
            $permissions = DB::instance()->table("permissions")->get(["id", "permissions", "color"])->results();
            $permits = explode(",", $permits->permissions);

            foreach ($permits as $permit) {
                foreach ($permissions as $permission) {
                    foreach (json_decode($permission->permissions) as $key => $value) {
                        if ($permit == $key && $value == 1) {
                            $mods = DB::instance()->table("users")->where("permissions", "=", $permission->id)->get(["id", "username"])->results();
                            foreach ($mods as $user) {
                                array_push($moderators, "<a href='" . route('profile.index_by_id', ["id" => $user->id]) . "'><font color='{$permission->color}'>{$user->username}</font></a>");
                            }
                        }
                    }
                }
            }
        }

        return $moderators;
    }

    public function checkPermissions ($id) {
        $permissions = $this->where("id", "=", $id)->get(["permissions"])->count() > 0 ? $this->first()->permissions : [];
        $permissions = explode(",", $permissions);

        foreach ($permissions as $permission) {

            if (Auth::permissions($permission)) {
                return true;
            }

        }

        return false;
    }

    public function getCategory ($category_id) {
        return $this->where("id", "=", $category_id)->and("parent", "not_null")->or("url_name", "=", $category_id)->and("parent", "not_null")->get()->count() > 0 ? $this->first() : null;
    }

    public function getSectionCategories ($section_id) {

        $section_id = !is_numeric($section_id) ? $this->getSection($section_id) ? $this->getSection($section_id)->id : 0 : $section_id;

        return $this->where("parent", "=", $section_id)->or("url_name", "=", $section_id)->get()->count() > 0 ? $this->results() : null;

    }

    public function getSectionByCategory ($id) {
        $parent = $this->where("id", "=", $id)->get(["parent"])->count() > 0 ? $this->first()->parent : null;
        return $parent == null ? null : $this->where("id", "=", $parent)->get()->first();
    }

    public function getSection ($section_id) {

        return $this->where("id", "=", $section_id)->or("url_name", "=", $section_id)->get()->count() > 0 ? $this->first() : null;

    }

    public function getSections () {

        return $this->where("parent", "null")->get()->count() > 0 ? $this->results() : null;

    }

}