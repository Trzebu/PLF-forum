<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\AdminModels\SystemRegistry;

final class SystemRegistryController extends Controller {

    public function __construct () {
        parent::__construct();
        $this->reg = new SystemRegistry();
    }

    public function view () {
        $this->view->registry = $this->reg->getAllRegistry();
        $this->view->render("admin.general.system_registry.view");
    }

}