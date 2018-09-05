<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Section;
use App\Models\Vote;
use Libs\Token;

final class PostController extends Controller {

    public function viewIndex ($sectionName, $categoryId, $postId, $postSlugUrl = null) {
        $post = new Post();
        $section = new Section();

        $this->view->parent_post = $post->getSubjectData($postId, $section->getCategory($categoryId)->id);
        if ($this->view->parent_post !== null) {
            $post->visitIncrement($postId);
            $this->view->answers = $post->getAnswers($postId);
            $this->view->user = new User();
            $this->view->vote = new Vote();
            $this->view->urlToken = Token::generate("url_token");
            $this->view->section_id = $sectionName;
            $this->view->category_id = $categoryId;
        }

        $this->view->render("post.viewIndex");
    }

}