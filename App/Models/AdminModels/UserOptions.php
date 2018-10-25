<?php

namespace App\Models\AdminModels;

use App\Models\Post;
use App\Models\Files;
use App\Models\Permissions;
use Libs\Model;
use Libs\DataBase\DataBase as DB;

final class UserOptions extends Model {

    protected $_table = "users";

    public function deleteFiles ($userId) {
        $file = new Files();
        $amount = 0;
        $files = DB::instance()
                    ->table("users_files")
                    ->where("user_id", "=", $userId)
                    ->get(["id"])
                    ->results();

        foreach ($files as $fil) {
            $amount = $amount + $file->remove($fil->id);
        }

        return $amount;
    }

    public function deletePosts ($userId) {
        $post = new Post();
        $amount = 0;

        $posts = DB::instance()
                        ->table("posts")
                        ->where("user_id", "=", $userId)
                        ->and("parent", "not_null")
                        ->get(["id"])
                        ->results();

        foreach ($posts as $pos) {
            $amount = $amount + $post->deletePost($pos->id);
        }

        return $amount;
    }

    public function deleteThreads ($userId) {
        $post = new Post();
        $amount = 0;

        $threads = DB::instance()
                        ->table("posts")
                        ->where("user_id", "=", $userId)
                        ->and("parent", "null")
                        ->get(["id"])
                        ->results();

        foreach ($threads as $thread) {
            $amount = $amount + $post->deleteThread($thread->id);
        }

        return $amount;
    }

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
        $permissions = new Permissions();
        return $permissions->getRank();
    }

}