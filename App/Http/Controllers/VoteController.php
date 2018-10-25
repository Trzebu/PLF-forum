<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\Post;
use Libs\Token;
use Libs\User as Auth;
use Libs\Session;
use Libs\Config;

final class VoteController extends Controller {

    public function give ($type, $sectionId, $categoryId, $parentPostId, $postId, $token) {

        if (!Token::check("url_token", $token)) {
            return $this->redirect("home.index");
        }

        if (!Auth::permissions("voting")) {
            Session::flash("alert_error", "You can not give vote, because you have no permissions to voting.");
            return $this->redirect("home.index");
        }

        $post = new Post();

        if ($post->getAnswer($postId) === null) {
            return $this->redirect("home.index");  
        }

        if ($post->getAnswer($postId)->user_id == Auth::data()->id) {
            return $this->redirect("post.to_post_index", [
                "sectionName" => $sectionId,
                "categoryId" => $categoryId,
                "postId" => $parentPostId,
                "answerId" => "#post_{$postId}"
            ]);
        }

        $vote = new Vote();  
        $postHasVotes = $vote->calcVotes($postId);

        if ($postHasVotes == Config::get("posting/voting/max_votes_per_post") 
            || $postHasVotes == Config::get("posting/voting/min_votes_per_post")) {
            Session::flash("alert_error", "This post has maximum possible votes.");
            return $this->redirect("post.to_post_index", [
                "sectionName" => $sectionId,
                "categoryId" => $categoryId,
                "postId" => $parentPostId,
                "answerId" => "#post_{$postId}"
            ]);
        }

        if (!$vote->checkThatVoteIsGiven($postId)) {

            $vote->give($type, $postId, $post->getAnswer($postId)->user_id);

        } else {
            
            $type = $type == "up" ? 1 : 0;

            if ($vote->checkGivenVoteType($postId) == $type) {
                $vote->removeVote($postId);
            } else {
                $vote->changeVote($type, $postId);
            }

        }

        return $this->redirect("post.to_post_index", [
            "sectionName" => $sectionId,
            "categoryId" => $categoryId,
            "postId" => $parentPostId,
            "answerId" => "#post_{$postId}"
        ]);

    }

}