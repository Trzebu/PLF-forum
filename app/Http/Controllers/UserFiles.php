<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\User;
use Libs\Http\Request;
use Libs\Session;
use Libs\User as Auth;
use Libs\Token;

final class UserFiles extends Controller {

    public function __construct () {
        parent::__construct();
        $this->file = new Files();
    }

    public function remove ($fileId, $token) {
        if (!Token::check("remove_token", $token)) {
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        if ($this->file->getFile($fileId) === null) {
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        if (Auth()->data()->id != $this->file->getFile($fileId)->user_id 
            && !Auth()->permissions("file_managing")) {
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        $this->file->remove($fileId);

        Session::flash("alert_success", "File has been deleted.");
        return $this->redirect('user_files.index');
    }

    public function setAsAvatar ($fileId, $token) {
        if (!Token::check("set_as_avatar", $token)) {
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        if ($this->file->getFile($fileId) === null) {
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        if ($this->file->isValidImage($this->file->getFile($fileId)->path) === null) {
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        $resol = $this->file->getImageSize($fileId);

        if ($resol->width > 300 
            || $resol->height > 300 
            || $resol->width < 200 
            || $resol->height < 200) {
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        $user = new User();
        $user->changeUserSettings([
            "avatar" => $this->file->getFile($fileId)->id
        ]);

        Session::flash("alert_success", "Your avatar has been changed!");
        return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
    }

    public function duplicate ($fileId, $token) {

        if (!Auth::permissions("file_uploading")) {
            Session::flash("alert_error", "You have no permissions to duplicating files.");
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        if (!Token::check("duplicate", $token)) {
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        if ($this->file->getFile($fileId) === null) {
            return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
        }

        $id = $this->file->duplicate($fileId);

        if ($id !== false) {
            Session::flash("alert_success", "File has been dupliacted to your files.");
            return $this->redirect("user_files.view_file", ["fileId" => $id]);
        }

        Session::flash("alert_error", "Problem when copying a file.");
        return $this->redirect("user_files.view_file", ["fileId" => $fileId]);
    }

    public function viewFile ($fileId) {
        $this->view->file = $this->file;
        $this->view->user = new User();
        $this->view->data = $this->view->file->getFile($fileId);
        $this->view->isValidImage = false;

        if ($this->view->data !== null) {
            if ($this->file->isValidImage($this->view->data->path)) {
                $resol = $this->file->getImageSize($fileId);
                if ($resol->width <= 300 
                    && $resol->height <= 300 
                    && $resol->width >= 200 
                    && $resol->height >= 200) {
                    $this->view->isValidImage = true;
                }
            }
        }

        $this->view->render("user_files.view_file");

    }

    public function uploadNew () {

        if (!Auth::permissions("file_uploading")) {
            Session::flash("alert_error", "You have no permissions to uploading files.");
            return $this->redirect("user_files.index");
        }

        if ($this->validation(Request::input(), [
            "file" => "required|file",
            "upload_file_token" => "token"
        ])) {
            $this->file->upload(Request::input("file"));
        }

        return $this->redirect("user_files.index");
    }

    public function uploadAvatar () {
        if (!Auth::permissions("file_uploading")) {
            Session::flash("alert_error", "You have no permissions to uploading files.");
            return $this->redirect("auth.options");
        }
        
        if ($this->validation(Request::input(), [
            "image" => "required|file>image:gif,x-icon,bmp>max_size:256000>min_resolution:200,200>max_resolution:300,300",
            "avatar_change_token" => "token"
        ])) {
            $user = new User();
            $user->changeUserSettings([
                "avatar" => $this->file->upload(Request::input("image"))
            ]);
        }

        return $this->redirect("auth.options");
    }

    public function index () {
        $this->view->file = $this->file;

        $this->view->files = $this->file->getMyFiles();
        $this->view->render("user_files.index");

    }

}