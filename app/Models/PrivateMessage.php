<?php

namespace App\Models;

use Libs\Model;
use Libs\User as Auth;
use App\Models\User;

final class PrivateMessage extends Model {

    protected $_table = "private_messages";

    public function getThreads () {
        $threads = $this->where("user_id", "=", Auth::data()->id)->or("to_user_id", "=", Auth::data()->id)->get(["user_id", "to_user_id"])->results();
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