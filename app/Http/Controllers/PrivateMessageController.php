<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PrivateMessage;
use App\Models\User;

final class PrivateMessageController extends Controller {

    public function index () {
        $message = new PrivateMessage();
        $this->view->user = new User();
        $this->view->threads = $message->getThreads();
        $this->view->render("message.view");
    }

}