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

    public function newPermissionSend () {
        if (!$this->validation(Request::input(), [
            "name" => "required",
            "add_permission_token" => "token"
        ])) {
            return $this->redirect("admin.permissions.new");
        }

        $permisison = json_decode($this->permissions->getRank()[0]->permissions, true);

        if (array_key_exists(Request::input("name"), $permisison)) {
            Session::flash("alert_error", "This name is already used.");
            return $this->redirect("admin.permissions.new");
        }
    }

    public function delete ($id, $token) {
        if (count($this->permissions->getRank($id)) < 1 ) {
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

        if (count($data) < 1) {
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

        if (count($this->view->data) < 1) {
            Session::flash("alert_info", "Group you are searching does not exists.");
            return $this->redirect("admin.permissions.groups");
        }

        $this->view->groups = $this->permissions->getRank();
        $this->view->permissions = json_decode($this->view->data->permissions);
        $this->view->render("admin.permissions.general.editGroup");
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