<?php

namespace App\Models;

use Libs\Model;
use Libs\User as Auth;

final class Friends extends Model {

    protected $_table = "friends";

    public function getFriends ($userId) {
        $friends = $this->where("user_id", "=", $userId)
                    ->or("friend_id", "=", $userId)
                    ->get(["friend_id", "user_id", "type"])
                    ->count() > 0 ? $this->results() : null;
        $ids = [];

        if ($friends !== null) {
            foreach ($friends as $friend) {
                if (Auth::data()->id == $friend->user_id ) {
                    array_push($ids, [
                        "id" => $friend->friend_id,
                        "type" => $friend->type
                    ]);
                } else {
                    array_push($ids, [
                        "id" => $friend->user_id,
                        "type" => $friend->type
                    ]);
                }
            }
        }

        return count($ids) > 0 ? $ids : null;

    }

    public function acceptRequest ($friendId) {
        $this->where("user_id", "=", $friendId)->and("friend_id", "=", Auth::data()->id)->update([
            "type" => 2
        ]);
    }

    public function remove ($friendId) {
        $this->where("user_id", "=", Auth::data()->id)
            ->and("friend_id", "=", $friendId)
            ->or("user_id", "=", $friendId)
            ->and("friend_id", "=", Auth::data()->id)
            ->delete();
    }

    public function sendRequest ($friendId, $type) {
        $this->insert([
            "user_id" => Auth::data()->id,
            "friend_id" => $friendId,
            "type" => $type
        ]);
    }

    public function friendSendRequestToUser ($friendId) {
        return (bool) $this->where("user_id", "=", $friendId)
                            ->and("friend_id", "=", Auth::data()->id)
                            ->and("type", "=", 1)
                            ->numRow() > 0;
    }

    public function userSendRequestToFriend ($friendId) {
        return (bool) $this->where("user_id", "=", Auth::data()->id)
                            ->and("friend_id", "=", $friendId)
                            ->and("type", "=", 1)
                            ->numRow() > 0;
    }

    public function checkUserAndFriendAreRelated ($friendId) {
        return (bool) $this->where("user_id", "=", Auth::data()->id)
                            ->and("friend_id", "=", $friendId)
                            ->and("type", "=", 2)
                            ->or("user_id", "=", $friendId)
                            ->and("friend_id", "=", Auth::data()->id)
                            ->and("type", "=", 2)
                            ->numRow() > 0;
    }

    public function friendIsBlockedByUser ($friendId) {
        return (bool) $this->where("user_id", "=", Auth::data()->id)->and("friend_id", "=", $friendId)->and("type", "=", 3)->numRow() > 0;
    }

    public function userIsBlocekdByFriend ($friendId) {
        return (bool) $this->where("user_id", "=", $friendId)->and("friend_id", "=", Auth::data()->id)->and("type", "=", 3)->numRow() > 0;
    }

}