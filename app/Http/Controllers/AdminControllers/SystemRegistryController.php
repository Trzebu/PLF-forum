<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\SystemRegistry;
use Libs\Http\Request;
use Libs\Session;

final class SystemRegistryController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->reg = new SystemRegistry();
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