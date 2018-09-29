<?php

namespace Libs;
use Libs\Str;
use Libs\Arr;
use Libs\Config;

class TemplateCompiler {

    private $_code = [];
    private $_includes = [];
    private $_line = 0;

    public function __construct ($path) {
        $this->startCompile($path);
    }

    private function startCompile ($path) {
        if($file = file_get_contents(__ROOT__ . Config::get("dirs/view") . "/" . Config::get("theme") . "/" . $path . ".temp.php")) {
            $this->_code = explode("\n", $file);
            $this->cleareCode();
            $this->compile();
            $this->templateSave($path);
            $this->checkIncludes();
        }
    }

    private function checkIncludes () {
        for ($i = 0; $i < count($this->_includes); $i++) {
            $include = trim(Str::replace($this->_includes[$i], ["." => "/"]));
            array_shift($this->_includes);
            $this->_code = [];
            $this->startCompile($include);
        }
    }

    private function templateSave ($path) {
        $path = __ROOT__ . Config::get("dirs/compiled_templates") . "/" . Str::replace(Config::get("theme") . "/" . $path, ["/" => "."]) . ".ctemp.php";
        if (!is_dir(__ROOT__ . "/storage/views")) {
            mkdir(__ROOT__ . "/storage/views", 0700, true);
        }
        $file = fopen($path, 'c');
        $codeToSave = "";
        foreach ($this->_code as $code) {
            $codeToSave .= $code . "\n";
        }
        file_put_contents($path, $codeToSave);
        fclose($file);
    }

    private function compile () {
        for ($i = 0; $i < count($this->_code); $i++) {
            $this->_line = $i;

            if (strpos($this->_code[$i], "@") !== false) {
                $command = ltrim($this->_code[$i], "@");
                $params = explode(" ", $command);
                $command = trim($params[0]);
                array_shift($params);

                switch ($command) {
                    case "include":
                        $this->includes($params);
                    break;
                    case "if":
                        $this->if($params);
                    break;
                    case "elseif":
                        $this->elseif($params);
                    break;
                    case "else":
                        $this->else();
                    break;
                    case "endif":
                        $this->endif();
                    break;
                    case "foreach":
                        $this->foreach($params);
                    break;
                    case "endforeach":
                        $this->endforeach();
                    break;
                    case "for":
                        $this->for($params);
                    break;
                    case "endfor":
                        $this->endfor();
                    break;
                }

            } else if ((strpos($this->_code[$i], "{{") !== false) && (strpos($this->_code[$i], "}}") !== false)) {
                $this->variable_echo();
            } else if ((strpos($this->_code[$i], "{?") !== false) && (strpos($this->_code[$i], "?}") !== false)) {
                $this->variable_declare();
            }

        }
    }

    private function cleareCode () {
        for ($i = 0; $i < count($this->_code);) {

            $this->_code[$i] = $this->removeSpace($this->_code[$i]);

            if (strlen($this->_code[$i]) == 1) {
                unset($this->_code[$i]);
            } else {
                $i++;
            }

            $this->_code = Arr::fixLowHigh($this->_code);
        }
    }

    private function removeSpace ($str) {
        for ($i = 0; $i < strlen($str); $i++) {
            $str = rtrim($str, " ");
            $str = ltrim($str, " ");
        }
        return $str;
    }

    //*********Vars echo*****************

    private function variable_echo () {
        $this->_code[$this->_line] = preg_replace('/{{(.*?)}}/', '<?= ${1} ?>', $this->_code[$this->_line]);
    }

    //*********Vars declaring*****************

    private function variable_declare () {
        $this->_code[$this->_line] = preg_replace('/\{\?(.*?)\?\}/', '<?php ${1} ?>', $this->_code[$this->_line]);
    }

    //*******All synatx*************

    private function endfor () {
        $this->_code[$this->_line] = "<?php endfor; ?>";
    }

    private function for ($params) {
        $this->_code[$this->_line] = "<?php for" . implode(" ", $params) . " ?>";
    }

    private function endforeach () {
        $this->_code[$this->_line] = "<?php endforeach; ?>";
    }

    private function foreach ($params) {
        $this->_code[$this->_line] = "<?php foreach" . implode(" ", $params) . " ?>";
    }

    private function endif () {
        $this->_code[$this->_line] = "<?php endif; ?>";
    }

    private function else () {
        $this->_code[$this->_line] = "<?php else: ?>";
    }

    private function elseif ($params) {
        $this->_code[$this->_line] = "<?php elseif" . implode(" ", $params) . " ?>";
    }

    private function if ($params) {
        $this->_code[$this->_line] = "<?php if" . implode(" ", $params) . " ?>";
    }

    private function includes ($params) {
        if (count($this->_line) > 1) {
            die("Error in compilation. Wrong parametr for include.");
        }

        $params = trim(Str::replace($params[0], ["/" => "."]));
        $theme = Config::get("theme");
        $this->_code[$this->_line] = "<?php include(\"{$theme}.{$params}\" . \".ctemp.php\"); ?>";
        array_push($this->_includes, $params);
    }

}