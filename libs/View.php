<?php
namespace Libs;
use Exception;
use Libs\Session;
use Libs\Validation\ValidationErrors;
use Libs\TemplateCompiler;
use Libs\Config;
use Libs\Str;

class View {

    public function flash ($name, $string = null) {
        return Session::flash($name, $string);
    }

    public function exists ($name) {
        return Session::exists($name);
    }

    public function render ($path) {
        $path = str_replace(".", "/", $path);
        $ctempPath = __ROOT__ . Config::get("dirs/compiled_templates") . "/" . Str::replace($path, ["/" => "."]) . ".ctemp.php";
        try {
            if (!file_exists(__ROOT__ . Config::get("dirs/view") . "/" . $path . ".temp.php")) {
                Throw new Exception("Template {$path} not found.");
            } else if (!file_exists($ctempPath) && !Config::get("debug")) {
                Throw new Exception("Template {$path} is not compiled!");
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        
        if (Config::get("debug")) {
            $compile = new TemplateCompiler($path);
        }

        require_once $ctempPath;

        if (Config::get("debug")) {
            echo "<!-- WARNING! Currently your app is set in debug mode so templates are compiled in every website visit and all errors are displayed with details! -->";
        }

    }

}