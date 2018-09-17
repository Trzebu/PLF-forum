<?php

namespace App\Models;

use Libs\Model;
use Libs\User as Auth;
use App\Models\User;

final class PrivateMessage extends Model {

    protected $_table = "private_messages";

    public function getUnreadedMessagesAmount () {
        return (int) $this->where("to_user_id", "=", Auth::data()->id)
                    ->and("readed", "=", 0)
                    ->numRow();
    }

    public function getUnreadedMessagesByUser ($userId) {
        return (int) $this->where("user_id", "=", $userId)
                            ->and("to_user_id", "=", Auth::data()->id)
                            ->and("readed", "=", 0)
                            ->numRow();
    }

    public function send ($userId, $contents) {
        $this->insert([
            "user_id" => Auth::data()->id,
            "to_user_id" => $userId,
            "contents" => $contents
        ]);
    }

    public function getThread ($userId) {
        $this->where("user_id", "=", $userId)
                    ->and("to_user_id", "=", Auth::data()->id)
                    ->and("readed", "=", 0)
                    ->update([
                        "readed" => 1
                    ]);

        return $this->where("user_id", "=", Auth::data()->id)
                    ->and("to_user_id", "=", $userId)
                    ->or("user_id", "=", $userId)
                    ->and("to_user_id", "=", Auth::data()->id)
                    ->get()
                    ->count() > 0 ? (object) $this->results() : (bool) false;
    }

    public function getThreads () {
        $threads = $this->where("user_id", "=", Auth::data()->id)->or("to_user_id", "=", Auth::data()->id)->orderBy(["created_at"])->get(["user_id", "to_user_id"])->results();
        $users = [];

        if (count($threads) > 0) {

            foreach ($threads as $thread) {
                if (!in_array($thread->user_id, $users) && !in_array($thread->to_user_id, $users)) {
                    if (Auth::data()->id == $thread->user_id) {
                        array_push($users, $thread->to_user_id);
                    } else {
                        array_push($users, $thread->user_id);
                    }
                }
            }

        }

        return (array) $users;
    }

}