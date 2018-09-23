<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Section;
use Libs\Model;
use Libs\User as Auth;

final class ModerationNotes extends Model {

    protected $_table = "moderation_notes";

    public function editPostNote ($postId, $from, $to) {
        $post = new Post();
        $contents = "[i]System:[/i]
            Your answer has been edited from:
            [quote]
            {$post->getAnswer($postId)->contents}
            [/quote]
            to:
            [quote]
            {$to}
            [/quote]
        ";
        $this->insert([
            "user_id" => $post->getAnswer($postId)->user_id,
            "mod_id" => Auth::data()->id,
            "contents" => $contents
        ]);
    }

    public function removeRestoryNote ($postId, $action) {
        $post = new Post();
        $contents = "[i]System:[/i]
            Your answer:
            [quote]
            {$post->getAnswer($postId)->contents}
            [/quote]
            has been {$action}.
        ";
        $this->insert([
            "user_id" => $post->getAnswer($postId)->user_id,
            "mod_id" => Auth::data()->id,
            "contents" => $contents
        ]);
    }

    public function openCloseNote ($postId, $action) {
        $post = new Post();
        $contents = "[i]System:[/i]
            Your thread [b]{$post->getAnswer($postId)->subject}[/b] was {$action}.
        ";
        $this->insert([
            "user_id" => $post->getAnswer($postId)->user_id,
            "mod_id" => Auth::data()->id,
            "contents" => $contents
        ]);
    }

    public function moveToNote ($postId, $newCategoryId) {
        $post = new Post();
        $section = new Section();
        $contents = "[i]Sestem:[/i]
            Your thread has been moved from [b]{$section->getCategory($post->getAnswer($postId)->category)->name}[/b] to [b]{$section->getCategory($newCategoryId)->name}[/b].
        ";

        $this->insert([
            "user_id" => $post->getAnswer($postId)->user_id,
            "mod_id" => Auth::data()->id,
            "contents" => $contents
        ]);
    }

    public function getNotes ($userId) {
        return $this->where("user_id", "=", $userId)->orderBy(["id"])->get()->results();
    }

    public function add ($userId, $contents) {
        $this->insert([
            "user_id" => $userId,
            "mod_id" => Auth::data()->id,
            "contents" => $contents
        ]);
    }

}