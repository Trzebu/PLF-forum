<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Friends;
use Libs\Tools\SlugUrl;
use Libs\Token;
include __ROOT__ . "/libs/Bbcode/BbCode.php";

final class ProfileController extends Controller {

    public function usersList () {
        $this->view->user = new User();
        $this->view->render("user.users_list");
    }

    public function index ($id, $username = null) {
        $user = new User();
        $post = new Post();
        $this->view->data = $user->data($id);

        if ($this->view->data === null) {
            return $this->redirect("home.index");
        }

        if (strlen($this->view->data->about) > 0) {
            $bb = new \BbCode();
            $bb->parse($this->view->data->about, false);
            $this->view->about = $bb->getHtml(); 
        } else {
            $this->view->about = null;
        }

        $this->view->title = "Forum - {$this->view->data->username} profile";
        $this->view->user = $user;
        $this->view->friend = new Friends();
        $this->view->friends = $this->view->friend->getFriends($this->view->data->id);
        $this->view->urlToken = Token::generate("url_token");
        $this->view->threads = $post->calcThreadsCreatedByUser($this->view->data->id);
        $this->view->answers = $post->calcAnswersCreatedByUser($this->view->data->id);
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