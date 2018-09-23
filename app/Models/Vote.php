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

        $votesPositive = $this->where("post_id", "=", $postId)->and("type", "=", 1)->numRow();
        $votesNegative = $this->where("post_id", "=", $postId)->and("type", "=", 0)->numRow();

        return $votesPositive - $votesNegative;
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