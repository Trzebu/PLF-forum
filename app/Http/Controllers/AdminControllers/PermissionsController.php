<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Permissions;
use App\Models\User;
use Libs\Http\Request;
use Libs\Session;
use Libs\Config;
use Libs\Token;

final class PermissionsController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->permissions = new Permissions();
    }

    public function deletePermission ($name, $token) {
        if (!Token::check("delete_permission_token", $token)) {
            Session::flash("alert_error", trans("validation.token"));
            return $this->redirect("admin.permissions.edit_permission", ["name" => $name]);
        }

        $permissions = $this->permissions->getRank();
        $this->view->permission_name = $name;

        if (!array_key_exists($name, json_decode($permissions[0]->permissions))) {
            Session::flash("alert_error", "Permission you are searching does not exists.");
            return $this->redirect("admin.permissions.view");
        }

        foreach ($permissions as $permission) {
            $new_permissions = json_decode($permission->permissions, true);
            unset($new_permissions[$name]);
            $this->permissions->editPermission($permission->id, [
                "permissions" => json_encode($new_permissions)
            ]);
        }

        Session::flash("alert_info", "Permission {$name} has been deleted.");
        $this->redirect('admin.permissions.view');
    }

    public function editPermissionSend ($name) {
        $permissions = $this->permissions->getRank();
        $this->view->permission_name = $name;

        if (!array_key_exists($name, json_decode($permissions[0]->permissions))) {
            Session::flash("alert_error", "Permission you are searching does not exists.");
            return $this->redirect("admin.permissions.view");
        }

        foreach ($permissions as $permission) {
            $new_permissions = json_decode($permission->permissions, true);
            $value = $new_permissions[$name];
            unset($new_permissions[$name]);
            $new_permissions = array_merge($new_permissions, [Request::input("name") => $value]);
            $this->permissions->editPermission($permission->id, [
                "permissions" => json_encode($new_permissions)
            ]);
        }

        Session::flash("alert_success", "Permission has been changed.");
        $this->redirect("admin.permissions.edit_permission", ["name" => Request::input("name")]);
    }

    public function newPermissionSend () {
        if (!$this->validation(Request::input(), [
            "name" => "required",
            "setted" => "num>min:0>max:1",
            "add_permission_token" => "token"
        ])) {
            return $this->redirect("admin.permissions.new");
        }

        $permissions = $this->permissions->getRank();

        if (array_key_exists(Request::input("name"), json_decode($permissions[0]->permissions, true))) {
            Session::flash("alert_error", "This name is already used.");
            return $this->redirect("admin.permissions.new");
        }

        foreach ($permissions as $permission) {
            $new_permissions = array_merge(json_decode($permission->permissions, true), [Request::input("name") => intval(Request::input("setted"))]);
            $this->permissions->editPermission($permission->id, [
                "permissions" => json_encode($new_permissions)
            ]);
        }

        Session::flash("alert_success", "New permission has been created.");
        $this->redirect("admin.permissions.new");
    }

    public function delete ($id, $token) {
        if (!$this->permissions->getRank($id)) {
            Session::flash("alert_info", "Group you are searching does not exists.");
            return $this->redirect("admin.permissions.groups");
        }

        if (!Token::check("delete_group_token", $token)) {
            Session::flash("alert_info", trans("validation.token"));
            $this->redirect("admin.permissions.groups.view", ["id" => $id]);
        }

        $this->permissions->deleteGroup($id);

        Session::flash("alert_success", "Group has been deleted.");
        $this->redirect("admin.permissions.groups");
    }

    public function changeByOtherGroup ($id) {
        if (count($this->permissions->getRank(Request::input("group"))) < 1 ||
            count($this->permissions->getRank($id)) < 1 ) {
            Session::flash("alert_info", "Group you are searching does not exists.");
            return $this->redirect("admin.permissions.groups");
        }

        if (!$this->validation(Request::input(), [
            "change_groups_by_other_token" => "token"
        ])) {
            Session::flash("alert_info", trans("validation.token"));
            $this->redirect("admin.permissions.groups.view", ["id" => $id]);
        }

        $user = new User();
        $amount = $user->changeUsersGroup(Request::input("group"), $id);

        Session::flash("alert_success", "This group has been setted for {$amount} users!");
        $this->redirect("admin.permissions.groups.view", ["id" => $id]);
    }

    public function groupNewSend () {
        if (!$this->validation(Request::input(), [
            "name" => "required",
            "color" => "required",
            "add_group_token" => "token"
        ])) {
            return $this->redirect("admin.permissions.groups.new");
        }

        $this->permissions->addNewPermission([
            "name" => Request::input("name"),
            "color" => Request::input("color"),
            "permissions" => json_encode(Request::input("permissions")),
        ]);

        Session::flash("alert_success", "Your new group has been added!");
        $this->redirect("admin.permissions.groups");
    }

    public function groupViewEdit ($id) {
        $data = $this->permissions->getRank($id)[0];

        if (!$data) {
            Session::flash("alert_info", "Group you are searching does not exists.");
            return $this->redirect("admin.permissions.groups");
        }

        if (!$this->validation(Request::input(), [
            "name" => "required",
            "color" => "required",
            "edit_group_token" => "token"
        ])) {
            return $this->redirect("admin.permissions.groups.view", ["id" => $id]);
        }

        $this->permissions->editPermission($id, [
            "name" => Request::input("name"),
            "color" => Request::input("color"),
            "permissions" => json_encode(Request::input("permissions")),
        ]);

        Session::flash("alert_success", "Changes has been saved!");
        $this->redirect("admin.permissions.groups.view", ["id" => $id]);
    }

    public function groupView ($id) {
        $this->view->data = $this->permissions->getRank($id)[0];

        if (!$this->view->data) {
            Session::flash("alert_info", "Group you are searching does not exists.");
            return $this->redirect("admin.permissions.groups");
        }

        $this->view->groups = $this->permissions->getRank();
        $this->view->permissions = json_decode($this->view->data->permissions);
        $this->view->render("admin.permissions.general.editGroup");
    }

    public function editPermission ($name) {
        $permissions = json_decode($this->permissions->getRank()[0]->permissions);
        $this->view->permission_name = $name;

        if (!array_key_exists($name, $permissions)) {
            Session::flash("alert_error", "Permission you are searching does not exists.");
            return $this->redirect("admin.permissions.view");
        }

        $this->view->render("admin.permissions.edit_permission");
    }

    public function viewPermissions () {
        $this->view->permissions = json_decode($this->permissions->getRank()[0]->permissions);
        $this->view->render("admin.permissions.view_permissions");
    }

    public function newPermission () {
        $this->view->render("admin.permissions.new");
    }

    public function groupNew () {
        $this->view->permissions = json_decode($this->permissions->getRank()[0]->permissions);
        $this->view->render("admin.permissions.general.newGroup");
    }

    public function groups () {
        $this->view->permissions = $this->permissions;
        $this->view->render("admin.permissions.general.groups");
    }

}