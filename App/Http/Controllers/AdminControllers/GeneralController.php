<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Libs\Http\Request;
use Libs\Session;
use Libs\Config;

final class GeneralController extends Controller {

    public function boardSettingsChange () {
        if (!$this->validation(Request::input(), [
            "name" => "required",
            "board_settings_token" => "token"
        ])) {
            Session::flash("alert_error", trans("validation.token"));
            return $this->redirect("admin.general_settings.board_settings");
        }

        if (!in_array(Request::input("lang"), scandir(__ROOT__ . "/resources/lang"))) {
            Session::flash("alert_error", "Lang pack you are trying set is broken.");
            return $this->redirect("admin.general_settings.board_settings");
        }

        Config::edit("page/contents/title", Request::input("name"));
        Config::edit("page/language/default", Request::input("lang"));
        Config::edit("page/language/user_change", Request::input("user_lang") == 1 ? "true" : "false");

        Session::flash("alert_success", "Changes has been saved.");
        $this->redirect("admin.general_settings.board_settings");
    }

    public function defaultThemeChange () {
        if (!$this->validation(Request::input(), [
            "set_theme_token" => "token"
        ])) {
            Session::flash("alert_error", trans("validation.token"));
            return $this->redirect("admin.general_settings.theme");
        }

        if (!in_array(Request::input("theme"), scandir(__ROOT__ . "/resources/views"))) {
            Session::flash("alert_error", "Theme you are want to set does not exists.");
            return $this->redirect("admin.general_settings.theme");
        }   

        Config::edit("forum/theme/default_theme", Request::input("theme"));

        Session::flash("alert_success", "Theme changed!");
        $this->redirect("admin.general_settings.theme");
    }

    public function boardSettings () {
        $this->view->lang_packs = [];

        foreach (scandir(__ROOT__ . "/resources/lang") as $lang) {
            if (strpos($lang, ".") === false) {
                $info = include(__ROOT__ . "/resources/lang/{$lang}/info.php");
                $this->view->lang_packs = array_merge($this->view->lang_packs, [$lang => $info["translated_name"]]);
            }
        }

        $this->view->render("admin.general.board_settings.board_settings");
    }

    public function defaultTheme () {
        $this->view->render("admin.general.board_settings.default_theme");
    }

    public function phpInfo () {
        $this->view->render("admin.general.php_info");
    }

    public function generalView () {
        $this->view->render("admin.general.general");
    }

}