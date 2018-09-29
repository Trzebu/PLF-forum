<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModerationNotes;
use App\Models\User;
use Libs\User as Auth;
use Libs\Http\Request;
use Libs\Session;

final class ModerationNotesController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->notes = new ModerationNotes();
        $this->user = new User();
    }

    public function addPersonalNote ($userId) {

        if ($this->user->data($userId) === null) {
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("moderator")) {
            return $this->redirect("profile.index_by_id", [
                "id" => $userId
            ]);
        }

        if ($this->validation(Request::input(), [
            "post" => "required|str>min:10>max:65000",
            "post_token" => "token"
        ])) {
            Session::flash("alert_success", "Moderation note has benn added correctly.");
            $this->notes->add($userId, Request::input('post'));
        }

        return $this->redirect("profile.index_by_id", [
            "id" => $userId
        ]);
    }

}