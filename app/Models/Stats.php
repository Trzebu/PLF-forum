<?php

namespace App\Models;
use App\Models\Post;
use App\Models\Vote;
use App\Models\User;
use App\Models\Permissions;
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
        $permissions = new Permissions();
        $groups = $permissions->getRank();
        $groups_to_implode = [];

        foreach ($groups as $group) {
            array_push($groups_to_implode, "<a href='" . route('profile.users_list.by_group', ['id' => $group->id]) . "'><font color='{$group->color}'>{$group->name}</font></a>");
        }

        return $groups_to_implode;
    }

}