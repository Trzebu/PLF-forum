<?php
namespace Libs;
use Libs\Route;
use Libs\Http\Request;

class App {

    public function __construct () {
        foreach (scandir(__ROOT__ . '/routes/') as $dir) {
            if (strpos($dir, ".") !== 0) {
                require_once(__ROOT__ . '/routes/' . $dir);
            }
        }
        $route = Route::getRoutes(Request::url());

        if (!$route) {
            die("404 Error");
        }

        if (isset($route["route"][1]["middleware"])) {
            $middleware = require_once(__ROOT__ . "/config/middleware.php");
            foreach ($route["route"][1]["middleware"] as $midd) {
                new $middleware[$midd];
            }
        }

        $explodeToControllerName = explode("@", $route["route"][1]["uses"]);
        $this->controller = new $explodeToControllerName[0];
        call_user_func_array([$this->controller, $explodeToControllerName[1]], $route["params"]);
    }

}

