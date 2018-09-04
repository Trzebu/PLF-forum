<?php

namespace App\Models;
use Libs\Model;

final class Post extends Model {

    protected $_table = "posts";

    public function getAnswers ($postId) {
        return $this->where("parent", "=", $postId)->get()->count() > 0 ? $this->results() : null;
    }

    public function getSubjectData ($postId, $categoryId) {
        return $this->where("id", "=", $postId)->and("category", "=", $categoryId)->and("parent", "null")->get()->count() > 0 ? $this->first() : null;
    }

    public function getAnswersCount ($subjectId, $categoryId) {
        return $this->where("parent", "=", $subjectId)->and("category", "=", $categoryId)->numRow();
    }

    public function getLastPost ($subjectId, $categoryId) {
        return $this->where("parent", "=", $subjectId)->and("category", "=", $categoryId)->rowsLimit(1)->get()->count() > 0 ? $this->first() : null;
    }

    public function getLastSubject ($categoryId) {
        return $this->where("parent", "null")->and("category", "=", $categoryId)->rowsLimit(1)->get()->count() > 0 ? $this->first() : null;
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