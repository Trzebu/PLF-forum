<?php

namespace App\Models;

use Libs\Model;
use Libs\User as Auth;

final class Vote extends Model {

    protected $_table = "votes";

    public function allGivenVotes() {
        return $this->numRow();
    }

    public function calcVotes ($postId) {

        $votes = $this->where("post_id", "=", $postId)->get(["type"])->count() > 0 ? $this->results() : null;
        $votesAmount = 0;

        if ($votes !== null) {

            foreach ($votes as $vote) {
                if ($vote->type == 0) {
                    $votesAmount--;
                } else {
                    $votesAmount++;
                }
            }

        }

        return $votesAmount;
    }

    public function changeVote ($type, $postId) {
        $this->where("user_id", "=", Auth::data()->id)->and("post_id", "=", $postId)->update([
            "type" => $type
        ]);
    }

    public function removeVote ($postId) {
        $this->where("user_id", "=", Auth::data()->id)->and("post_id", "=", $postId)->delete();
    }

    public function checkGivenVoteType ($postId) {
        return $this->where("user_id", "=", Auth::data()->id)->and("post_id", "=", $postId)->get(["type"])->count() > 0 ? $this->first()->type : null;
    }

    public function give ($type, $postId) {
        $type = $type == "up" ? 1 : 0;

        $this->insert([
            "user_id" => Auth::data()->id,
            "post_id" => $postId,
            "type" => $type
        ]);
    }

    public function checkThatVoteIsGiven ($postId) {
        return (bool) $this->where("user_id", "=", Auth::data()->id)->and("post_id", "=", $postId)->numRow() > 0 ? true : false;
    }

}