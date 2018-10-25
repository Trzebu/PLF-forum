<?php

namespace App\Models;

use Libs\Model;
use Libs\User as Auth;

final class Vote extends Model {

    protected $_table = "votes";
    
    public function deleteVotesRatedOnUser ($userId) {
        return $this->where("rated_user_id", "=", $userId)
                    ->delete()
                    ->count();
    }

    public function deleteRatedVotes ($userId) {
        return $this->where("user_id", "=", $userId)
                    ->delete()
                    ->count();
    }

    public function deleteVoteByPost ($postId) {
        return $this->where("post_id", "=", $postId)
                    ->delete()
                    ->count();
    }

    public function allGivenVotes() {
        return $this->numRow();
    }

    public function calcVotes ($postId) {
        $amount = 0;
        $votes = $this->where("post_id", "=", $postId)->get()->results();

        foreach ($votes as $vote) {
            if ($vote->type == 1) {
                $amount++;
            } else {
                $amount--;
            }
        }

        return $amount;
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

    public function give ($type, $postId, $userId) {
        $type = $type == "up" ? 1 : 0;

        $this->insert([
            "user_id" => Auth::data()->id,
            "post_id" => $postId,
            "type" => $type,
            "rated_user_id" => $userId
        ]);
    }

    public function checkThatVoteIsGiven ($postId) {
        return (bool) $this->where("user_id", "=", Auth::data()->id)->and("post_id", "=", $postId)->numRow() > 0 ? true : false;
    }

}