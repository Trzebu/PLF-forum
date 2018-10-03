<?php

namespace App\Models;

use Libs\Model;
use Libs\User as Auth;
use Libs\Config;

final class Files extends Model {
    protected $_table = "users_files";

    public function remove ($id) {
        unlink(__ROOT__ . Config::get("uploading/upload_dir") . $this->getFile($id)->path);
        $this->where("id", "=", $id)->delete();
    }

    public function getImageSize ($fileId) {
        $data = getimagesize(__ROOT__ . Config::get("uploading/upload_dir") . $this->getFile($fileId)->path);
        return $data == null ? false : (object) [
            "width" => $data[0],
            "height" => $data[1]
        ];
    }

    public function duplicate ($fileId) {
        $source_file = $this->getFile($fileId);
        $newFileName = uniqid(true);
        $ext = pathinfo($source_file->path, PATHINFO_EXTENSION);
        $path = __ROOT__ . Config::get("uploading/upload_dir");

        if (copy($path . $source_file->path, "{$path}{$newFileName}.{$ext}")) {
            return $this->insert([
                "user_id" => Auth::data()->id,
                "original_name" => $source_file->original_name,
                "path" => "{$newFileName}.{$ext}",
                "size" => $source_file->size
            ])->lastInsertedID();
        }

        return false;
    }

    public function isValidImage ($path) {
        $validExtansion = ["jpg", "jpeg", "png"];

        return (bool) in_array(pathinfo($path, PATHINFO_EXTENSION), $validExtansion);
    }

    public function getFile ($fileId) {
        return $this->where("id", "=", $fileId)->get()->count() > 0 ? $this->first() : (unset) null;
    }

    public function getMyFiles () {
        return $this->where("user_id", "=", Auth::data()->id)->orderBy(["created_at"])->paginate(100)->get()->count() > 0 ? $this->results() : (unset) null;
    }

    public function upload ($file) {
        $name = uniqid(true);
        $file = (object) $file;
        $ext = pathinfo($file->name, PATHINFO_EXTENSION);

        move_uploaded_file($file->tmp_name, __ROOT__ . Config::get("uploading/upload_dir") . "/{$name}.{$ext}");

        return (int) $this->insert([
            "user_id" => Auth::data()->id,
            "original_name" => $file->name,
            "path" => "{$name}.{$ext}",
            "size" => $file->size
        ])->lastInsertedID();
    }

}