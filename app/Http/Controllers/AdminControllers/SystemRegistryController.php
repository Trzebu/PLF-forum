<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\SystemRegistry;
use Libs\Http\Request;
use Libs\Session;
use Libs\Config;
use Libs\Token;

final class SystemRegistryController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->reg = new SystemRegistry();
    }

    public function removeRegistry ($id, $token) {
        $reg = $this->reg->getRegistry($id);

        if ($reg === null) {
            Session::flash("alert_error", "Given registry dosn't exists.");
            return $this->redirect("admin.general_settings.system_registry");
        }

        if (!$this->reg->permissions($reg->mode, "edit_reg")) {
            Session::flash("alert_info", "You have no permissions to edit given registry.");
            return $this->redirect("admin.general_settings.system_registry.edit", [
                "id" => $reg->id
            ]);
        }

        if (!Token::check("remove_register_token", $token)) {
            Session::flash("alert_info", "Token expired. Try again.");
            return $this->redirect("admin.general_settings.system_registry.edit", [
                "id" => $reg->id
            ]);
        }

        $this->reg->registerRemove($reg->id);

        Session::flash("alert_success", "Register {$reg->registry_name} has been deleted.");
        return $this->redirect("admin.general_settings.system_registry");
    }

    public function editRegistryParams ($id) {
        $reg = $this->reg->getRegistry($id);

        if ($reg === null) {
            Session::flash("alert_error", "Given registry dosn't exists.");
            return $this->redirect("admin.general_settings.system_registry");
        }

        if (!$this->reg->permissions($reg->mode, "edit_reg")) {
            Session::flash("alert_info", "You have no permissions to edit given registry.");
            return $this->redirect("admin.general_settings.system_registry.edit", [
                "id" => $reg->id
            ]);
        }

        if ($this->validation(Request::input(), [
            "registry_name" => ["required|unique:system_registry", "registry name"],
            "type" => ["required", "registry type"],
            "reading" => "num>min:0>max:1",
            "editing_value" => "num>min:0>max:1",
            "editing_registry" => "num>min:0>max:1",
            "edit_registry_token" => "token",
        ])) {
            $this->reg->editRegistry($reg->id, [
                "registry_name" => Request::input("registry_name"),
                "type" => Request::input("type"),
                "mode" => Request::input("reading") . Request::input("editing_value") . Request::input("editing_registry")
            ]);
            Session::flash("alert_success", "Registry {$reg->registry_name} has been edited!");
        }

        return $this->redirect("admin.general_settings.system_registry.edit", [
            "id" => $reg->id
        ]);
    }

    public function editRegistryValue ($id) {
        $reg = $this->reg->getRegistry($id);

        if ($reg === null) {
            Session::flash("alert_error", "Given registry dosn't exists.");
            return $this->redirect("admin.general_settings.system_registry");
        }

        if (!$this->reg->permissions($reg->mode, "edit_value")) {
            Session::flash("alert_info", "You have no permissions to edit given registry.");
            return $this->redirect("admin.general_settings.system_registry.edit", [
                "id" => $reg->id
            ]);
        }

        if ($this->validation(Request::input(), [
            "edit_registry_value_token" => "token"
        ])) {
            $this->reg->editRegistry($reg->id, [
                "value" => Request::input("value")
            ]);
        }

        Session::flash("alert_success", "Register value edited!");
        return $this->redirect("admin.general_settings.system_registry.edit", [
            "id" => $reg->id
        ]);
    }

    public function editRegistry ($id) {
        $reg = $this->reg->getRegistry($id);

        if ($reg === null) {
            Session::flash("alert_error", "Given registry dosn't exists.");
            return $this->redirect("admin.general_settings.system_registry");
        }

        if (!$this->reg->permissions($reg->mode, "edit_value") &&
            !$this->reg->permissions($reg->mode, "edit_reg")) {
            Session::flash("alert_info", "You have no permissions to edit given registry.");
            return $this->redirect("admin.general_settings.system_registry");
        }

        $this->view->register = $reg;
        $this->view->reg = $this->reg;
        $this->view->render("admin.general.system_registry.edit");
    }

    public function addNewRegistryPost () {
        if ($this->validation(Request::input(), [
            "registry_name" => ["required|unique:system_registry", "registry name"],
            "value" => ["required", "registry value"],
            "type" => ["required", "registry type"],
            "reading" => "num>min:0>max:1",
            "editing_value" => "num>min:0>max:1",
            "editing_registry" => "num>min:0>max:1",
            "registry_token" => "token",
        ])) {
            $this->reg->addNew([
                "registry_name" => Request::input("registry_name"),
                "type" => Request::input("type"),
                "value" => Request::input("value"),
                "mode" => Request::input("reading") . Request::input("editing_value") . Request::input("editing_registry")
            ]);
            Session::flash("alert_success", "New registry has been added!");
            return $this->redirect("admin.general_settings.system_registry");
        }

        return $this->redirect("admin.general_settings.system_registry.new");
    }

    public function addNewRegistry () {
        $this->view->render("admin.general.system_registry.new");
    }

    public function view () {
        $this->view->registry = $this->reg->getAllRegistry();
        
        usort($this->view->registry, function ($x, $y) { 
            return strcasecmp($x->registry_name, $y->registry_name);
        });
        
        $this->view->reg = $this->reg;
        $this->view->render("admin.general.system_registry.view");
    }

}