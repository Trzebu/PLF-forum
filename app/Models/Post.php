<?php

namespace App\Models;
use Libs\Model;
use Libs\User as Auth;

final class Post extends Model {

    protected $_table = "posts";

    public function openThread ($postId) {
        $this->where("id", "=", $postId)->update([
            "status" => 0
        ]);
    }

    public function closeThread ($postId) {
        $this->where("id", "=", $postId)->update([
            "status" => 1
        ]);
    }

    public function moveTo ($postId, $categoryId) {
        $this->where("id", "=", $postId)->or("parent", "=", $postId)->update([
            "category" => $categoryId
        ]);
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

    public function newAnswer ($postId, $categoryId, $content) {
        $this->insert([
            "parent" => $postId,
            "category" => $categoryId,
            "user_id" => Auth::data()->id,
            "contents" => $content
        ]);
    }

    public function visitIncrement ($postId) {
        $visits = $this->where("id", "=", $postId)->get(["visits"])->first()->visits;
        $this->where("id", "=", $postId)->update([
            "visits" => $visits + 1
        ]);
    }

    public function getAnswer ($answerId) {
        return $this->where("id", "=", $answerId)->get()->count() > 0 ? $this->first() : null;
    }

    public function getAnswers ($postId) {
        return $this->where("parent", "=", $postId)->paginate(10)->get()->count() > 0 ? $this->results() : null;
    }

    public function getSubjectData ($postId, $categoryId) {
        return $this->where("id", "=", $postId)->and("category", "=", $categoryId)->and("parent", "null")->get()->count() > 0 ? $this->first() : null;
    }

    public function getAnswersCount ($subjectId, $categoryId) {
        return $this->where("parent", "=", $subjectId)->and("category", "=", $categoryId)->numRow();
    }

    public function getLastPost ($subjectId, $categoryId) {
        return $this->where("parent", "=", $subjectId)->and("category", "=", $categoryId)->orderBy(["id"])->rowsLimit(1)->get()->count() > 0 ? $this->first() : null;
    }

    public function getLastSubject ($categoryId) {
        return $this->where("parent", "null")->and("category", "=", $categoryId)->orderBy(["id"])->rowsLimit(1)->get()->count() > 0 ? $this->first() : null;
    }

    public function getSubjectsCount ($categoryId) {
        return $this->where("parent", "null")->and("category", "=", $categoryId)->numRow();
    }

    public function getPostsCount ($categoryId) {
        return $this->where("parent", "not_null")->and("category", "=", $categoryId)->numRow();
    }

    public function getPosts ($categoryId) {
        return $this->where("parent", "null")->and("category", "=", $categoryId)->orderBy(["id"])->paginate(10)->get()->count() > 0 ? $this : null;
    }

}