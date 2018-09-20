<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\User;
use Libs\Http\Request;
use Libs\Session;
use Libs\User as Auth;

final class UserFiles extends Controller {

    public function viewFile ($fileId) {
        $this->view->file = new Files();
        $this->view->user = new User();
        $this->view->data = $this->view->file->getFile($fileId);

        $this->view->render("user_files.view_file");

    }

    public function upload_new () {

        if (!Auth::permissions("file_uploading")) {
            Session::flash("alert_error", "You have no permissions to uploading files.");
            return $this->redirect("user_files.index");
        }

        if ($this->validation(Request::input(), [
            "file" => "required|file",
            "upload_file_token" => "token"
        ])) {
            $file = new Files();
            $file->upload(Request::input("file"));
        }

        return $this->redirect("user_files.index");
    }

    public function index () {

        $this->view->file = new Files();

        $this->view->files = $this->view->file->getMyFiles();
        $this->view->render("user_files.index");

    }

}