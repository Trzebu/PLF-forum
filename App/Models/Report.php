<?php

namespace App\Models;

use App\Models\Section;
use Libs\Model;
use Libs\Config;
use Libs\DataBase\DataBase as DB;
use Libs\User as Auth;

final class Report extends Model {

    protected $_table = "reports";
    private $_managingByPermissions = [
        "post" => "section",
        "file" => "file_managing",
        "profile" => "moderator"
    ];

    public function getMyReports () {
        return $this->where("user_id", "=", Auth::data()->id)
                    ->and("parent", "null")
                    ->orderBy(["created_at"])
                    ->get()
                    ->count() > 0 ? $this->results() : (unset) null;
    }

    public function sendResponse ($id, $contents) {
        return $this->insert([
            "user_id" => Auth::data()->id,
            "parent" => $id,
            "reason" => $contents
        ])->lastInsertedId();
    }

    public function caseUpdate ($id, $fields) {
        return $this->where("id", "=", $id)->update($fields);
    }

    public function getReport ($id) {
        return $this->where("id", "=", $id)
                    ->or("parent", "=", $id)
                    ->get()
                    ->count() > 0 ? $this->results() : null;
    }

    public function modHasPermissions ($type, $id) {
        $section = new Section();

        if ($type == "post") {
            $category = DB::instance()->table("posts")->where("id", "=", $id)->get(["category"])->first()->category;
            return $section->checkPermissions($category);
        } else if ($type == "file") {
            return Auth::permissions($this->_managingByPermissions[$type]);
        } else if ($type == "profile") {
            return Auth::permissions($this->_managingByPermissions[$type]);
        }
    }

    public function getAll () {
        return $this->where("status", "=", 0)
                    ->and("parent", "null")
                    ->or("status", "=", 1)
                    ->and("parent", "null")
                    ->or("mod_id", "=", Auth::data()->id)
                    ->and("parent", "null")
                    ->orderBy(["status"])
                    ->paginate(Config::get("report/view/per_page"))
                    ->get()
                    ->count() > 0 ? $this->results() : (unset) null;
    }

    public function new ($fields) {
        return (int) $this->insert($fields)->lastInsertedId();
    }

    public function isReported ($id, $contentType) {
        return (bool) $this->where("content_id", "=", $id)->and("content_type", "=", $contentType)->numRow() > 0;
    }

}