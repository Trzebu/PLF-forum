<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Section;
use Libs\Model;
use Libs\Config;
use Libs\User as Auth;

final class ModerationNotes extends Model {

    protected $_table = "moderation_notes";

    public function getNotes ($userId) {
        return $this->where("user_id", "=", $userId)
                    ->orderBy(["id"])
                    ->rowsLimit(Config::get("moderation/moderation_notes/personal_notes/results/max"))
                    ->get()
                    ->results();
    }

    public function add ($userId, $contents) {
        $this->insert([
            "user_id" => $userId,
            "mod_id" => Auth::data()->id,
            "contents" => $contents
        ]);
    }

}