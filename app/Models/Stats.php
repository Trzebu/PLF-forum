<?php

namespace App\Models;
use App\Models\Post;
use App\Models\Vote;
use App\Models\User;
use Libs\DataBase\DataBase as DB;

final class Stats {

    public static function threads () {
        $post = new Post();
        return $post->allSubjectsCount();
    }

    public static function posts () {
        $post = new Post();
        return $post->allPostsCount();
    }

    public static function votes () {
        $vote = new Vote();
        return $vote->allGivenVotes();
    }

    public static function accounts () {
        $user = new User();
        return $user->accountsCount();
    }

    public static function lastRegistered () {
        $user = new User();
        return $user->getLastTenRegisteredAccounts();
    }

    public static function getGroups () {
        $groups = DB::instance()->table("permissions")->get(["name", "color"])->results();
        $groups_to_implode = [];

        foreach ($groups as $group) {
            array_push($groups_to_implode, "<font color='{$group->color}'>{$group->name}</font>");

        }

        return $groups_to_implode;
    }

}