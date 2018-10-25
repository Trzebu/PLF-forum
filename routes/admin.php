<?php

use Libs\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
| You can use here the middleware group.
|
*/

Route::get("/admin", [
    "uses" => "App\Http\Controllers\AdminControllers\GeneralController@generalView",
    "as" => "admin.index",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings", [
    "uses" => "App\Http\Controllers\AdminControllers\GeneralController@generalView",
    "as" => "admin.general_settings",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@redirectToManageForums",
    "as" => "admin.forums",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/system_registry", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@view",
    "as" => "admin.general_settings.system_registry",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/php_info", [
    "uses" => "App\Http\Controllers\AdminControllers\GeneralController@phpInfo",
    "as" => "admin.general_settings.php_info",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/system_registry/new", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@addNewRegistry",
    "as" => "admin.general_settings.system_registry.new",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/system_registry/new/post", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@addNewRegistryPost",
    "as" => "admin.general_settings.system_registry.new.post",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/system_registry/edit/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@editRegistry",
    "as" => "admin.general_settings.system_registry.edit",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/system_registry/edit/edit_value/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@editRegistryValue",
    "as" => "admin.general_settings.system_registry.edit.edit_value",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/system_registry/edit/edit_register/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@editRegistryParams",
    "as" => "admin.general_settings.system_registry.edit.edit_register",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/system_registry/edit/remove/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\SystemRegistryController@removeRegistry",
    "as" => "admin.general_settings.system_registry.edit.remove",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@view",
    "as" => "admin.general_settings.manage_users",
    "middleware" => ["permissions"]
]);

/*
|--------------------------------------------------------------------------
| Users Manage
|--------------------------------------------------------------------------
|
| Here is where are located all routes to managing users.
|
*/

Route::post("/admin/general_settings/manage_users/find", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@find",
    "as" => "admin.general_settings.manage_users.find",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/view/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@viewUser",
    "as" => "admin.general_settings.manage_users.view_user",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/edit/base/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@editBase",
    "as" => "admin.general_settings.manage_users.edit.base",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/edit/new_password/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@newPassword",
    "as" => "admin.general_settings.manage_users.edit.new_password",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/manage/ban_ip/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@banIp",
    "as" => "admin.general_settings.manage_users.manage.ban_ip",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/manage/move_threads/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@moveThreads",
    "as" => "admin.general_settings.manage_users.manage.move_threads",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/manage/change_rank/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@changeRank",
    "as" => "admin.general_settings.manage_users.manage.change_rank",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/manage/add_warnings/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@addWarnings",
    "as" => "admin.general_settings.manage_users.manage.add_warnings",
    "middleware" => ["permissions"]
]);

Route::post("/admin/general_settings/manage_users/delete/account/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@deleteAccount",
    "as" => "admin.general_settings.manage_users.delete.account",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/reset/warnings/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@resetWarnings",
    "as" => "admin.general_settings.manage_users.reset.warnings",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/delete/threads/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@deleteThreads",
    "as" => "admin.general_settings.manage_users.delete.threads",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/delete/posts/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@deletePosts",
    "as" => "admin.general_settings.manage_users.delete.posts",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/delete/posts_and_threads/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@deletePostsAndThreads",
    "as" => "admin.general_settings.manage_users.delete.posts_and_threads",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/delete/files/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@deleteFiles",
    "as" => "admin.general_settings.manage_users.delete.files",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/delete/pm_box/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@deletePmBox",
    "as" => "admin.general_settings.manage_users.delete.pm_box",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/reset/given_votes/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@resetGivenVotes",
    "as" => "admin.general_settings.manage_users.reset.given_votes",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/reset/reputation/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@resetReputation",
    "as" => "admin.general_settings.manage_users.reset.reputation",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/delete/additional_info/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@deleteAdditionalInfo",
    "as" => "admin.general_settings.manage_users.delete.additional_info",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/clear/about/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@clearAbout",
    "as" => "admin.general_settings.manage_users.clear.about",
    "middleware" => ["permissions"]
]);

Route::get("/admin/general_settings/manage_users/delete/avatar/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ManageUsersController@deleteAvatar",
    "as" => "admin.general_settings.manage_users.delete.avatar",
    "middleware" => ["permissions"]
]);

/*
|--------------------------------------------------------------------------
| Manage Forums
|--------------------------------------------------------------------------
|
| Here is where are located all routes to managing forums.
|
*/

Route::get("/admin/forums/manage_forums", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@manageForums",
    "as" => "admin.forums.manage_forums",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/manage_forums/queue/{dir}/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@sectionQueue",
    "as" => "admin.forums.manage_forums.queue",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/new_forum", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@newForum",
    "as" => "admin.forums.new_forum",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/new_forum/{sectionId}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@newForum",
    "as" => "admin.forums.new_forum.by_section",
    "middleware" => ["permissions"]
]);

Route::post("/admin/forums/new_forum/create", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@newForumPost",
    "as" => "admin.forums.new_forum.create",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/delete/section/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@deleteSection",
    "as" => "admin.forums.delete.section",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/delete/category/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@deleteCategory",
    "as" => "admin.forums.delete.category",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/manage_forums/options/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@forumOptions",
    "as" => "admin.forums.manage_forums.options",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/manage_forums/options/reset_forum_password/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@resetPassword",
    "as" => "admin.forums.manage_forums.options.reset_password",
    "middleware" => ["permissions"]
]);

Route::post("/admin/forums/manage_forums/options/save/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@forumOptionsSave",
    "as" => "admin.forums.manage_forums.options.save",
    "middleware" => ["permissions"]
]);

Route::post("/admin/forums/manage_forums/options/move/categories/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@moveCategories",
    "as" => "admin.forums.manage_forums.options.move.categories",
    "middleware" => ["permissions"]
]);

Route::post("/admin/forums/manage_forums/options/move/posts/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@movePosts",
    "as" => "admin.forums.manage_forums.options.move.posts",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/manage_forums/options/delete/posts/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@deletePostsFromCategory",
    "as" => "admin.forums.manage_forums.options.delete.posts",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/manage_forums/options/delete/categories/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@deleteCategoriesFromSection",
    "as" => "admin.forums.manage_forums.options.delete.categories",
    "middleware" => ["permissions"]
]);

Route::get("/admin/forums/settings", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@settingsView",
    "as" => "admin.forums.settings.view",
    "middleware" => ["permissions"]
]);

Route::post("/admin/forums/settings", [
    "uses" => "App\Http\Controllers\AdminControllers\ForumsController@settingsSet",
    "as" => "admin.forums.settings.set",
    "middleware" => ["permissions"]
]);

/*
|--------------------------------------------------------------------------
| Contents settings
|--------------------------------------------------------------------------
|
| Here is where are located all routes to contents settings.
|
*/

Route::get("/admin/contents", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@view",
    "as" => "admin.contents.view",
    "middleware" => ["permissions"]
]);

Route::get("/admin/contents/posting", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@posting",
    "as" => "admin.contents.posting",
    "middleware" => ["permissions"]
]);

Route::post("/admin/contents/posting", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@postingSet",
    "as" => "admin.contents.posting",
    "middleware" => ["permissions"]
]);

Route::get("/admin/contents/threads", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@threads",
    "as" => "admin.contents.threads",
    "middleware" => ["permissions"]
]);

Route::post("/admin/contents/threads", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@threadsSet",
    "as" => "admin.contents.threads",
    "middleware" => ["permissions"]
]);

Route::get("/admin/contents/private_messages", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@privateMessages",
    "as" => "admin.contents.private_messages",
    "middleware" => ["permissions"]
]);

Route::post("/admin/contents/private_messages", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@privateMessagesSent",
    "as" => "admin.contents.private_messages",
    "middleware" => ["permissions"]
]);

Route::get("/admin/contents/moderation", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@moderation",
    "as" => "admin.contents.moderation",
    "middleware" => ["permissions"]
]);

Route::post("/admin/contents/moderation", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@moderationSet",
    "as" => "admin.contents.moderation",
    "middleware" => ["permissions"]
]);

Route::get("/admin/contents/downloads/settings", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@downloads",
    "as" => "admin.contents.downloads.settings",
    "middleware" => ["permissions"]
]);

Route::get("/admin/contents/downloads/user_avatar", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@avatar",
    "as" => "admin.contents.downloads.avatar",
    "middleware" => ["permissions"]
]);

Route::post("/admin/contents/downloads/user_avatar", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@avatarSet",
    "as" => "admin.contents.downloads.avatar",
    "middleware" => ["permissions"]
]);

Route::post("/admin/contents/downloads/settings", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@downloadsSet",
    "as" => "admin.contents.downloads.settings",
    "middleware" => ["permissions"]
]);

Route::get("/admin/contents/authentication", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@authentication",
    "as" => "admin.contents.authentication",
    "middleware" => ["permissions"]
]);

Route::post("/admin/contents/authentication", [
    "uses" => "App\Http\Controllers\AdminControllers\ContentsController@authenticationSet",
    "as" => "admin.contents.authentication",
    "middleware" => ["permissions"]
]);

/*
|--------------------------------------------------------------------------
| Permissions
|--------------------------------------------------------------------------
|
| Here is where are located all routes to permissions.
|
*/

Route::get("/admin/permissions/groups", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@groups",
    "as" => "admin.permissions.groups",
    "middleware" => ["permissions"]
]);

Route::get("/admin/permissions/group/new", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@groupNew",
    "as" => "admin.permissions.groups.new",
    "middleware" => ["permissions"]
]);

Route::post("/admin/permissions/group/new", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@groupNewSend",
    "as" => "admin.permissions.groups.new",
    "middleware" => ["permissions"]
]);

Route::get("/admin/permissions/groups/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@groupView",
    "as" => "admin.permissions.groups.view",
    "middleware" => ["permissions"]
]);

Route::get("/admin/permissions/groups/delete/{id}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@delete",
    "as" => "admin.permissions.groups.delete",
    "middleware" => ["permissions"]
]);

Route::get("/admin/permissions/new_permission", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@newPermission",
    "as" => "admin.permissions.new",
    "middleware" => ["permissions"]
]);

Route::post("/admin/permissions/new_permission", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@newPermissionSend",
    "as" => "admin.permissions.new",
    "middleware" => ["permissions"]
]);

Route::post("/admin/permissions/groups/edit/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@groupViewEdit",
    "as" => "admin.permissions.groups.view.edit",
    "middleware" => ["permissions"]
]);

Route::post("/admin/permissions/groups/change_users_group/by_other_group/{id}", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@changeByOtherGroup",
    "as" => "admin.permissions.groups.change_users_group.by_other_group",
    "middleware" => ["permissions"]
]);

Route::get("/admin/permissions/view_permissions", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@viewPermissions",
    "as" => "admin.permissions.view",
    "middleware" => ["permissions"]
]);

Route::get("/admin/permissions/edit_permission/{name}", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@editPermission",
    "as" => "admin.permissions.edit_permission",
    "middleware" => ["permissions"]
]);

Route::post("/admin/permissions/edit_permission/{name}", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@editPermissionSend",
    "as" => "admin.permissions.edit_permission",
    "middleware" => ["permissions"]
]);

Route::get("/admin/permissions/delete/{name}/{token}", [
    "uses" => "App\Http\Controllers\AdminControllers\PermissionsController@deletePermission",
    "as" => "admin.permissions.delete_permission",
    "middleware" => ["permissions"]
]);