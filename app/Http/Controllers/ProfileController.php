<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Libs\Tools\SlugUrl;

final class ProfileController extends Controller {

    public function index ($id, $username = null) {
        $user = new User();
        $this->view->data = $user->data($id);

        if ($this->view->data === null) {
            return $this->redirect("home.index");
        }

        $this->view->render("user.profile");

    }

    public function redirectToIndex ($id) {
        $user = new User();
        $data = $user->data($id);

        if ($data === null) {
            return $this->redirect("home.index");
        }

        return $this->redirect('profile.index', [
            "id" => $id,
            "username" => SlugUrl::generate($data->username)
        ]);
    }

}