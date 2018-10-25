<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Friends;
use App\Models\ModerationNotes;
use Libs\Tools\SlugUrl;
use Libs\Token;
use Libs\Session;
use Libs\Config;
use Libs\Smilies;
use Libs\User as Auth;
include __ROOT__ . "/Libs/Bbcode/BbCode.php";

final class ProfileController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->user = new User();
    }

    public function usersListByGroup ($id) {
        $this->view->user = $this->user;
        $this->view->list = $this->user->getUsersByGroup($id);
        $this->view->render("user.users_list");
    }

    public function usersList () {
        $this->view->user = $this->user;
        $this->view->list = $this->user->getUsers();
        $this->view->render("user.users_list");
    }

    public function index ($id, $username = null) {
        $post = new Post();
        $this->view->data = $this->user->data($id);
        $this->view->about = null;
        
        if ($this->view->data === null) {
            return $this->redirect("home.index");
        }

        if ($this->user->accountDeleted($id)) {
            Session::flash("alert_info", "User you are search has deleted account.");
            return $this->redirect("profile.users_list");
        }

        if (strlen($this->view->data->about) > 0) {
            $this->view->about = $this->view->data->about;
            if (Config::get("user/auth/about/contents/bbcode")) {
                $bb = new \BbCode();
                $bb->parse($this->view->about, false);
                $this->view->about = $bb->getHtml();
            }
            if (config("user/auth/about/contents/smilies")) {
                $this->view->about = Smilies::parse($this->view->about);
            }
        }

        $this->view->title = "Forum - {$this->view->data->username} profile";
        $this->view->user = $this->user;
        $this->view->friend = new Friends();
        $this->view->notes = new ModerationNotes();
        $this->view->bb = new \BbCode();
        $this->view->urlToken = Token::generate("url_token");
        $this->view->friends = $this->view->friend->getFriends($this->view->data->id);
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