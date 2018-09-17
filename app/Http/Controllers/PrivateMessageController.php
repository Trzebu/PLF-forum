<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PrivateMessage;
use App\Models\User;
use App\Models\Friends;
use Libs\Session;
use Libs\Http\Request;
include __ROOT__ . "/libs/Bbcode/BbCode.php";

final class PrivateMessageController extends Controller {

    public function threadPost ($userId) {
        $user = new User();
        $friend = new Friends();
        $message = new PrivateMessage();

        if ($user->data($userId) == null) {
            Session::flash("alert_error", "This user dosen't exists!");
            return $this->redirect("message.view");
        }

        if ($friend->userIsBlocekdByFriend($userId)) {
            Session::flash("alert_error", "This user block you!");
            return $this->redirect("message.view");
        }

        if ($this->validation(Request::input(), [
            "post" => "max_string:65000|min_string:1",
            "post_token" => "token"
        ])) {
            $message->send($userId, Request::input("post"));
        }

        $this->redirect("message.thread", [
            "userId" => $userId
        ]);
    }

    public function thread ($userId) {
        $message = new PrivateMessage();
        $this->view->user = new User();
        $this->view->threadId = $userId;
        $this->view->bb = new \BbCode();
        $this->view->message = $message;
        $this->view->thread = $message->getThread($userId);
        $this->view->threads = $message->getThreads();
        $this->view->render("message.view");
    }

    public function index () {
        $message = new PrivateMessage();
        $this->view->user = new User();
        $this->view->thread = null;
        $this->view->message = $message;
        $this->view->threads = $message->getThreads();
        $this->view->render("message.view");
    }

}