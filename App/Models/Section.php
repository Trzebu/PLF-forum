<?php

namespace App\Models;

use App\Models\Permissions;
use App\Models\Post;
use Libs\Model;
use Libs\User as Auth;
use Libs\DataBase\DataBase as DB;

final class Section extends Model {

    protected $_table = "sections";

    public function deleteCategoriesFromSection ($sectionId) {
        $post = new Post();
        $categorys = $this->where("parent", "=", $sectionId)->get(["id"])->results();

        foreach ($categorys as $category) {
            $post->deleteThreadsByCategory($category->id);
        }

        $this->where("parent", "=", $sectionId)->delete();
    }

    public function moveCategory ($id, $newSection) {
        $this->where("id", "=", $id)->update([
            "parent" => $newSection
        ]);
    }

    public function moveCategories ($oldSection, $newSection) {        
        $this->where("parent", "=", $oldSection)->update([
            "parent" => $newSection
        ]);
    }

    public function deleteCategory ($id) {
        $post = new Post();
        $post->deleteThreadsByCategory($id);
        $this->where("id", "=", $id)->delete();
    }

    public function deleteSection ($id) {
        $post = new Post();
        $categorys = $this->where("parent", "=", $id)->get(["id"])->results();

        foreach ($categorys as $category) {
            $post->deleteThreadsByCategory($category->id);
        }

        $this->where("id", "=", $id)->or("parent", "=", $id)->delete();
    }

    public function highestValueAsQueue ($parent = null) {
        $sections = $parent === null ?
                    $this->where("parent", "null") :
                    $this->where("parent", "=", $parent);
        $sections = $this->get(["queue"])->results();

        usort($sections, function ($x, $y) {
            return $x->queue <=> $y->queue;
        });

        return end($sections)->queue;
    }

    public function sectionUpdate ($id, $fields) {
        return $this->where("id", "=", $id)
                    ->update($fields);
    }

    public function newRecord ($fields) {
        return $this->insert($fields)
                    ->lastInsertedID();
    }

    public function changeQueue ($id, $dir) {
        $dir = $dir == "up" ? -1 : 1;
        $move = $this->where("id", "=", $id)->get(["id", "parent", "queue"])->first();
        $other = is_null($move->parent) ?
                 $this->where("parent", "null") :
                 $this->where("parent", "=", $move->parent);
        $other = $this->get(["id", "parent", "queue"])->results();
        
        usort($other, function ($x, $y) {
            return $x->queue <=> $y->queue;
        });

        $new_position = $move->queue + $dir;
        $new_position = $new_position < 1 ? 1 : $new_position;
        $new_position = $new_position > count($other) ? count($other) : $new_position;
        $other = $other[$new_position - 1];

        if ($new_position == $move->queue) {
            return false;
        }

        $this->where("id", "=", $move->id)->update([
            "queue" => $new_position
        ]);

        $this->where("id", "=", $other->id)->update([
            "queue" => $dir < 0 ? $other->queue + 1 : $other->queue - 1
        ]);
    }

    public function getAllCategories () {
        return $this->where("parent", "not_null")
                    ->get()
                    ->results();
    }

    public function getSectionModerators ($sectionId) {
        $permits = explode(",", $this->where("id", "=", $sectionId)->get(["permissions"])->first()->permissions);

        if ($this->getSectionByCategory($sectionId) !== null) {
            $permits = array_merge($permits, explode(",", $this->where("id", "=", $this->getSectionByCategory($sectionId)->id)->get(["permissions"])->first()->permissions));
        }

        $moderators = [];
        $permits = array_unique($permits);
        $permissionsObject = new Permissions();

        if ($permits !== null) {
            $permissions = $permissionsObject->getRank();

            foreach ($permits as $permit) {
                foreach ($permissions as $permission) {
                    foreach (json_decode($permission->permissions) as $key => $value) {
                        if ($permit == $key && $value) {
                            $mods = DB::instance()
                                        ->table("users")
                                        ->where("permissions", "=", $permission->id)
                                        ->get(["id", "username"])
                                        ->results();
                            foreach ($mods as $user) {
                                $moderators = array_merge($moderators, [$user->username => [
                                    "id" => $user->id,
                                    "color" => $permission->color
                                ]]);
                            }
                        }
                    }
                }
            }
        }

        return $moderators;
    }

    public function checkPermissions ($id) {
        if ($id == 0 && Auth::permissions("global_moderator")) {
            return true;
        }

        $permissions = explode(",", $this->where("id", "=", $id)->get(["permissions"])->first()->permissions);

        if ($this->getSectionByCategory($id) !== null) {
            $permissions = array_merge($permissions, explode(",", $this->where("id", "=", $this->getSectionByCategory($id)->id)->get(["permissions"])->first()->permissions));
        }

        foreach ($permissions as $permission) {

            if (Auth::permissions($permission)) {
                return true;
            }
        }

        return false;
    }

    public function getCategory ($category_id) {
        return $this->where("id", "=", $category_id)
                    ->and("parent", "not_null")
                    ->or("url_name", "=", $category_id)
                    ->and("parent", "not_null")
                    ->get()
                    ->count() > 0 ? $this->first() : null;
    }

    public function getSectionCategories ($section_id) {
        $section_id = !is_numeric($section_id) ? $this->getSection($section_id) ? $this->getSection($section_id)->id : 0 : $section_id;

        return $this->where("parent", "=", $section_id)
                    ->or("url_name", "=", $section_id)
                    ->orderBy(["queue"], "ASC")
                    ->get()
                    ->count() > 0 ? $this->results() : null;
    }

    public function getSectionByCategory ($id) {
        $parent = $this->where("id", "=", $id)->get(["parent"])->count() > 0 ? $this->first()->parent : null;
        return $parent == null ? null : $this->where("id", "=", $parent)->get()->first();
    }

    public function getSection ($section_id) {
        return $this->where("id", "=", $section_id)
                    ->or("url_name", "=", $section_id)
                    ->get()
                    ->count() > 0 ? $this->first() : null;
    }

    public function getSections () {

        return $this->where("parent", "null")
                    ->orderBy(["queue"], "ASC")
                    ->get()
                    ->count() > 0 ? $this->results() : null;

    }

}