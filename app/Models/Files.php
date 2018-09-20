<?php

namespace App\Models;

use Libs\Model;
use Libs\User as Auth;
use Libs\Config;

final class Files extends Model {
    protected $_table = "users_files";

    public function isValidImage ($path) {
        $validExtansion = ["jpg", "jpeg", "png"];

        return (bool) in_array(pathinfo($path, PATHINFO_EXTENSION), $validExtansion);
    }

    public function getFile ($fileId) {
        return $this->where("id", "=", $fileId)->get()->count() > 0 ? $this->first() : (unset) null;
    }

    public function getMyFiles () {
        return $this->where("user_id", "=", Auth::data()->id)->get()->count() > 0 ? $this->results() : (unset) null;
    }

    public function upload ($file) {
        $name = uniqid(true);
        $file = (object) $file;
        $ext = pathinfo($file->name, PATHINFO_EXTENSION);

        move_uploaded_file($file->tmp_name, __ROOT__ . Config::get("upload_dir") . "/{$name}.{$ext}");

        return (int) $this->insert([
            "user_id" => Auth::data()->id,
            "original_name" => $file->name,
            "path" => "{$name}.{$ext}",
            "size" => $file->size
        ])->lastInsertedID();
    }

}