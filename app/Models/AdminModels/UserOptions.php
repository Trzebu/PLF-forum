<?php

namespace App\Models\AdminModels;

use App\Models\Post;
use Libs\Model;
use Libs\DataBase\DataBase as DB;

final class UserOptions extends Model {

    protected $_table = "users";

    public function moveThreads ($userId, $categoryId) {
        $post = new Post();

        $threads = DB::instance()
                        ->table("posts")
                        ->where("user_id", "=", $userId)
                        ->and("parent", "null")
                        ->get(["id"])
                        ->results();

        foreach ($threads as $thread) {
            $post->moveTo($thread->id, $categoryId);
        }
    }

    public function hasIpBan ($ip) {
        return (bool) DB::instance()
                            ->table("ip_bans")
                            ->where("ip", "=", $ip)
                            ->numRow() > 0;
    }

    public function removeIpBan ($ip) {
        return DB::instance()
                    ->table("ip_bans")
                    ->where("ip", "=", $ip)
                    ->delete();
    }

    public function giveIpBan ($ip, $reason) {
        return DB::instance()
                    ->table("ip_bans")
                    ->insert([
                        "ip" => $ip,
                        "reason" => $reason
                    ])->lastInsertedID();
    }

    public function getRanks () {
        return DB::instance()->table("permissions")->get(["id", "name"])->results();
    }

}