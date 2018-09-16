<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Friends;
use App\Models\User;
use Libs\Token;

final class FriendsController extends Controller {

    public function acceptFriendRequest ($userId, $token) {
        $friend = new Friends();
        $user = new User();

        if (!Token::check("url_token", $token)) {
            return $this->redirect("home.index");
        }

        if ($user->data($userId) === null) {
            return $this->redirect("home.index");
        }

        $friend->acceptRequest($userId);

        $this->redirect("profile.index_by_id", ["id" => $userId]);
    }

    public function removeFriend ($userId, $token) {
        $friend = new Friends();
        $user = new User();

        if (!Token::check("url_token", $token)) {
            return $this->redirect("home.index");
        }

        if ($user->data($userId) === null) {
            return $this->redirect("home.index");
        }

        if ($friend->userIsBlocekdByFriend($userId)) {
            return $this->redirect("home.index");
        }

        $friend->remove($userId);

        $this->redirect("profile.index_by_id", ["id" => $userId]);
    }

    public function addFriend ($type, $userId, $token) {
        $friend = new Friends();
        $user = new User();

        if (!Token::check("url_token", $token)) {
            return $this->redirect("home.index");
        }

        if ($user->data($userId) === null) {
            return $this->redirect("home.index");
        }

        if ($friend->checkUserAndFriendAreRelated($userId)) {
            return $this->redirect("home.index");
        }

        if ($friend->userSendRequestToFriend($userId) || $friend->friendSendRequestToUser($userId)) {
            return $this->redirect("home.index");
        }

        if ($friend->friendIsBlockedByUser($userId) || $friend->userIsBlocekdByFriend($userId)) {
            return $this->redirect("home.index");
        }

        $type = $type == "friend" ? 1 : 3;

        $friend->sendRequest($userId, $type);

        $this->redirect("profile.index_by_id", ["id" => $userId]);
    }

}