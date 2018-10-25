<?php

namespace App\Models;

use App\Models\Vote;
use Libs\Model;
use Libs\Config;
use Libs\User as Auth;

final class Post extends Model {

    protected $_table = "posts";
    
    public function movePostsTo ($oldCategory, $newCategory) {
        return $this->where("category", "=", $oldCategory)
                    ->update([
                        "category" => $newCategory
                    ]);
    }

    public function deleteThreadsByCategory ($categoryId) {
        return $this->where("category", "=", $categoryId)
                    ->delete();
    }

    public function getStickyThreads ($categoryId) {
        return $this->where("parent", "null")
                    ->and("sticky", "=", 1)
                    ->and("category", "=", $categoryId)
                    ->get()
                    ->results();
    }

    public function getGlobalThreads () {
        return $this->where("parent", "null")
                    ->and("category", "=", 0)
                    ->get()
                    ->results();
    }

    public function deletePost ($postId) {
        $vote = new Vote();
        $vote->deleteVoteByPost($postId);
        return $this->where("id", "=", $postId)
                    ->delete()
                    ->count();
    }

    public function deleteThread ($threadId) {
        $vote = new Vote();
        $vote->deleteVoteByPost($threadId);
        return $this->where("id", "=", $threadId)
                    ->or("parent", "=", $threadId)
                    ->delete()
                    ->count();
    }

    public function calcAnswersCreatedByUser ($id) {
        return $this->where("user_id", "=", $id)
                    ->and("parent", "not_null")
                    ->numRow();
    }

    public function calcThreadsCreatedByUser ($id) {
        return $this->where("user_id", "=", $id)
                    ->and("parent", "null")
                    ->numRow();
    }

    public function allPostsCount () {
        return $this->where("parent", "not_null")->numRow();
    }

    public function allSubjectsCount () {
        return $this->where("parent", "null")->numRow();
    }

    public function postUpdate ($postId, $fields) {
        $this->where("id", "=", $postId)
             ->update($fields);
    }

    public function moveTo ($postId, $categoryId) {
        $this->where("id", "=", $postId)
            ->or("parent", "=", $postId)
            ->update([
                "category" => $categoryId
            ]);
    }

    public function addNew ($fields) {
        return $this->insert($fields)
                    ->lastInsertedID();
    }

    public function addNewSubject ($title, $content, $category) {
        $this->insert([
            "category" => $category,
            "user_id" => Auth::data()->id,
            "subject" => $title,
            "contents" => $content
        ]);

        return $this->lastInsertedID();
    }

    public function visitIncrement ($postId) {
        $visits = $this->where("id", "=", $postId)->get(["visits"])->first()->visits;
        $this->where("id", "=", $postId)->update([
            "visits" => $visits + 1
        ]);
    }

    public function getAnswer ($answerId) {
        return $this->where("id", "=", $answerId)
                    ->get()
                    ->count() > 0 ? $this->first() : null;
    }

    public function getAnswers ($postId) {
        return $this->where("parent", "=", $postId)
                    ->paginate(Config::get("post/answers/per_page"))
                    ->get()
                    ->count() > 0 ? $this->results() : null;
    }

    public function postGetter ($postId) {
        return $this->where("id", "=", $postId)
                    ->get()
                    ->count() > 0 ? $this->first() : null;
    }

    public function getAnswersCount ($subjectId) {
        return $this->where("parent", "=", $subjectId)
                    ->numRow();
    }

    public function getLastPost ($subjectId) {
        return $this->where("parent", "=", $subjectId)
                    ->orderBy(["id"])
                    ->rowsLimit(1)
                    ->get()
                    ->count() > 0 ? $this->first() : null;
    }

    public function getLastSubject ($categoryId) {
        return $this->where("parent", "null")
                    ->and("category", "=", $categoryId)
                    ->orderBy(["id"])
                    ->rowsLimit(1)
                    ->get()
                    ->count() > 0 ? $this->first() : null;
    }

    public function getSubjectsCount ($categoryId) {
        return $this->where("parent", "null")
                ->and("category", "=", $categoryId)
                ->numRow();
    }

    public function getPostsCount ($categoryId) {
        return $this->where("parent", "not_null")
                    ->and("category", "=", $categoryId)
                    ->numRow();
    }

    public function getPosts ($categoryId) {
        return $this->where("parent", "null")
                    ->and("category", "=", $categoryId)
                    ->and("sticky", "null")
                    ->orderBy(["id"])
                    ->paginate(Config::get("category/view/post/per_page"))
                    ->get()
                    ->count() > 0 ? $this->results() : null;
    }

}