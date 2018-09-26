<?php

use Libs\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| You can use here the middleware group.
|
*/


Route::get("/", [
    "uses" => "App\Http\Controllers\HomeController@index",
    "as" => "home.index"
]);

//Auth

Route::get("/login", [
    "uses" => "App\Http\Controllers\AuthController@indexLogin",
    "as" => "auth.login",
    "middleware" => ["guest"]
]);

Route::post("/login", [
    "uses" => "App\Http\Controllers\AuthController@postLogin",
    "as" => "auth.login",
    "middleware" => ["guest"]
]);

Route::get("/register", [
    "uses" => "App\Http\Controllers\AuthController@indexRegister",
    "as" => "auth.register",
    "middleware" => ["guest"]
]);

Route::post("/register", [
    "uses" => "App\Http\Controllers\AuthController@postRegister",
    "as" => "auth.register",
    "middleware" => ["guest"]
]);

Route::get("/logout", [
    "uses" => "App\Http\Controllers\AuthController@logout",
    "as" => "auth.logout",
    "middleware" => ["auth"]
]);

//Section

Route::get("/section", [
    "uses" => "App\Http\Controllers\SectionController@index",
    "as" => "section.index"
]);

Route::get("/section/{sectionId}", [
    "uses" => "App\Http\Controllers\SectionController@viewCategories",
    "as" => "section.view_categories"
]);

Route::get("/section/{sectionName}/{categoryId}", [
    "uses" => "App\Http\Controllers\SectionController@viewCategoryPosts",
    "as" => "section.category_posts"
]);

//Post

Route::get("/section/{sectionName}/{categoryId}/{postId}/{postSlugUrl}", [
    "uses" => "App\Http\Controllers\PostController@viewIndex",
    "as" => "post.slug_index",
]);

Route::get("/section/{sectionName}/{categoryId}/{postId}", [
    "uses" => "App\Http\Controllers\PostController@viewIndex",
    "as" => "post.id_index",
]);

Route::get("/section/{sectionName}/{categoryId}/{postId}/{answerId}", [
    "uses" => "App\Http\Controllers\PostController@viewIndex",
    "as" => "post.to_post_index",
]);

Route::post("/answer/{sectionName}/{categoryId}/{postId}", [
    "uses" => "App\Http\Controllers\PostController@addAnswer",
    "as" => "post.add_answer",
    "middleware" => ["auth"]
]);

Route::get("/addSubject/{sectionName}/{categoryId}", [
    "uses" => "App\Http\Controllers\PostController@addSubject",
    "as" => "post.add_subject_to_category",
    "middleware" => ["auth"]
]);

Route::post("/addSubject/{categoryId}", [
    "uses" => "App\Http\Controllers\PostController@addSubjectPost",
    "as" => "post.add_subject_to_category_send",
    "middleware" => ["auth"]
]);

Route::post("/moveTo/{postId}/{categoryId}", [
    "uses" => "App\Http\Controllers\PostController@moveTo",
    "as" => "post.move_to",
    "middleware" => ["auth"]
]);

Route::post("/closeThread/{postId}/{categoryId}", [
    "uses" => "App\Http\Controllers\PostController@closeThread",
    "as" => "post.close_thread",
    "middleware" => ["auth"]
]);

Route::post("/openThread/{postId}/{categoryId}", [
    "uses" => "App\Http\Controllers\PostController@openThread",
    "as" => "post.open_thread",
    "middleware" => ["auth"]
]);

Route::get("/answer/{action}/{postId}/{token}", [
    "uses" => "App\Http\Controllers\PostController@actionAnswer",
    "as" => "post.remove_or_restore",
    "middleware" => ["auth"]
]);

Route::get("/post/edit/{postId}/{token}", [
    "uses" => "App\Http\Controllers\PostController@editPost",
    "as" => "post.edit",
    "middleware" => ["auth"]
]);

Route::post("/post/edit/{postId}", [
    "uses" => "App\Http\Controllers\PostController@editPostSend",
    "as" => "post.edit_send",
    "middleware" => ["auth"]
]);

//Vote

Route::get("/vote/{type}/{sectionId}/{categoryId}/{parentPostId}/{postId}/{token}", [
    "uses" => "App\Http\Controllers\VoteController@give",
    "as" => "vote.give",
    "middleware" => ["auth"]
]);

//User profile

Route::get("/profile/{id}/{username}", [
    "uses" => "App\Http\Controllers\ProfileController@index",
    "as" => "profile.index"
]);

Route::get("/profile/{id}", [
    "uses" => "App\Http\Controllers\ProfileController@redirectToIndex",
    "as" => "profile.index_by_id"
]);

Route::get("/profile", [
    "uses" => "App\Http\Controllers\ProfileController@usersList",
    "as" => "profile.users_list"
]);

//Friend actions

Route::get("/friend/add/{type}/{userId}/{token}", [
    "uses" => "App\Http\Controllers\FriendsController@addFriend",
    "as" => "friend.add",
    "middleware" => ["auth"]
]);

Route::get("/friend/remove/{userId}/{token}", [
    "uses" => "App\Http\Controllers\FriendsController@removeFriend",
    "as" => "friend.remove",
    "middleware" => ["auth"]
]);

Route::get("/friend/accetp/{userId}/{token}", [
    "uses" => "App\Http\Controllers\FriendsController@acceptFriendRequest",
    "as" => "friend.accept",
    "middleware" => ["auth"]
]);

//Private messages

Route::get("/messages", [
    "uses" => "App\Http\Controllers\PrivateMessageController@index",
    "as" => "message.view",
    "middleware" => ["auth"]
]);

Route::get("/messages/thread/{userId}", [
    "uses" => "App\Http\Controllers\PrivateMessageController@thread",
    "as" => "message.thread",
    "middleware" => ["auth"]
]);

Route::post("/messages/thread/{userId}", [
    "uses" => "App\Http\Controllers\PrivateMessageController@threadPost",
    "as" => "message.thread",
    "middleware" => ["auth"]
]);


//Users options

Route::get("/user/options", [
    "uses" => "App\Http\Controllers\AuthController@viewOptions",
    "as" => "auth.options",
    "middleware" => ["auth"]
]);

Route::get("/user/options/disable_avatar/{token}", [
    "uses" => "App\Http\Controllers\AuthController@disableAvatar",
    "as" => "auth.disable_avatar",
    "middleware" => ["auth"]
]);

Route::post("/user/options/base_settings", [
    "uses" => "App\Http\Controllers\AuthController@changeBaseSettings",
    "as" => "auth.base_settings",
    "middleware" => ["auth"]
]);

Route::post("/user/options/general_settings", [
    "uses" => "App\Http\Controllers\AuthController@changeGeneralSettings",
    "as" => "auth.general_settings",
    "middleware" => ["auth"]
]);

Route::post("/upload/upload_avatar", [
    "uses" => "App\Http\Controllers\UserFiles@uploadAvatar",
    "as" => "auth.change_avatar",
    "middleware" => ["auth"]
]);

//Users files

Route::get("/user_files", [
    "uses" => "App\Http\Controllers\UserFiles@index",
    "as" => "user_files.index",
    "middleware" => ["auth"]
]);

Route::get("/user_files/view/{fileId}", [
    "uses" => "App\Http\Controllers\UserFiles@viewFile",
    "as" => "user_files.view_file",
    "middleware" => ["auth"]
]);

Route::get("/user_files/duplicate/{fileId}/{token}", [
    "uses" => "App\Http\Controllers\UserFiles@duplicate",
    "as" => "user_files.duplicate",
    "middleware" => ["auth"]
]);

Route::get("/user_files/remove/{fileId}/{token}", [
    "uses" => "App\Http\Controllers\UserFiles@remove",
    "as" => "user_files.remove",
    "middleware" => ["auth"]
]);

Route::get("/user_files/{fileId}/set_as_avatar/{token}", [
    "uses" => "App\Http\Controllers\UserFiles@setAsAvatar",
    "as" => "user_files.set_as_avatar",
    "middleware" => ["auth"]
]);

Route::post("/user_files/upload_new", [
    "uses" => "App\Http\Controllers\UserFiles@uploadNew",
    "as" => "user_files.upload_new",
    "middleware" => ["auth"]
]);

//Moderation notes

Route::post("/moderation_notes/add_personal_note/{userId}", [
    "uses" => "App\Http\Controllers\ModerationNotesController@addPersonalNote",
    "as" => "moderation_notes.add_personal_note",
    "middleware" => ["auth"]
]);

//reports

Route::get("/report/{id}/{contents}/{token}", [
    "uses" => "App\Http\Controllers\ReportController@report",
    "as" => "report.contents",
    "middleware" => ["auth"]
]);

Route::post("/report/{id}/{contents}", [
    "uses" => "App\Http\Controllers\ReportController@reportPost",
    "as" => "report.contents_post",
    "middleware" => ["auth"]
]);

Route::get("/report/view", [ //moders view
    "uses" => "App\Http\Controllers\ReportController@viewReports",
    "as" => "report.view",
    "middleware" => ["auth"]
]);

Route::get("/report/view/{id}", [ //moders view
    "uses" => "App\Http\Controllers\ReportController@viewReportByID",
    "as" => "report.view_by_id",
    "middleware" => ["auth"]
]);