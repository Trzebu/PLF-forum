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

//Vote

Route::get("/vote/{type}/{sectionId}/{categoryId}/{parentPostId}/{postId}/{token}", [
    "uses" => "App\Http\Controllers\VoteController@give",
    "as" => "vote.give",
    "middleware" => ["auth"]
]);
