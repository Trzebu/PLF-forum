<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModerationNotes;
use App\Models\User;
use Libs\User as Auth;
use Libs\Http\Request;
use Libs\Session;
use Libs\Config;

final class ModerationNotesController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->notes = new ModerationNotes();
        $this->user = new User();
    }

    public function personalNote ($userId) {
        $this->view->data = $this->user->data($userId);

        if ($this->view->data === null) {
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("moderator")) {
            return $this->redirect("profile.index_by_id", [
                "id" => $userId
            ]);
        }

        $this->view->render("user.personal_note");
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

        if (!$this->validation(Request::input(), [
            "post" => "required|str>min:" .
                        Config::get("moderation/moderation_notes/personal_notes/length/min") .
                        ">max:" .
                        Config::get("moderation/moderation_notes/personal_notes/length/max"),
            "personal_note_token" => "token"
        ])) {
            return $this->redirect("moderation_notes.personal_note", [
                                    "userId" => $userId
                                ]);
        }

        Session::flash("alert_success", "Moderation note has benn added correctly.");
        $this->notes->add($userId, Request::input('post'));

        return $this->redirect("profile.index_by_id", [
            "id" => $userId
        ]);
    }

}