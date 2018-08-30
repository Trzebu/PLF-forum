<?php

namespace Libs;
use Libs\Str;
use Libs\Arr;
use Libs\Config;

class TemplateCompiler {

    private $_code = [];
    private $_includes = [];

    public function __construct ($path) {
        $this->startCompile($path);
    }

    private function startCompile ($path) {
        if($file = file_get_contents(__ROOT__ . Config::get("dirs/view") . "/" . $path . ".temp.php")) {
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
        $path = __ROOT__ . Config::get("dirs/compiled_templates") . "/" . Str::replace($path, ["/" => "."]) . ".ctemp.php";
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

            if (strpos($this->_code[$i], "@") !== false) {
                $command = ltrim($this->_code[$i], "@");
                $params = explode(" ", $command);
                $command = trim($params[0]);
                array_shift($params);
                $line = $i;

                switch ($command) {
                    case "include":
                        $this->includes($line, $params);
                    break;
                    case "if":
                        $this->if($line, $params);
                    break;
                    case "elseif":
                        $this->elseif($line, $params);
                    break;
                    case "else":
                        $this->else($line);
                    break;
                    case "endif":
                        $this->endif($line);
                    break;
                    case "foreach":
                        $this->foreach($line, $params);
                    break;
                    case "endforeach":
                        $this->endforeach($line);
                    break;
                }

            } else if ((strpos($this->_code[$i], "{{") !== false) && (strpos($this->_code[$i], "}}") !== false)) {
                $this->variable($i);
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

    //*********Vars*****************

    private function variable ($line) {
        $bracket = 0;
        $row = $this->_code[$line];
        $currentVarName = [];
        $vars = [];

        for ($i = 0; $i < strlen($row); $i++) {
            if ($row[$i] == "{") {
                $bracket++;
            } else if (($row[$i] == "}") && ($row[$i + 1] == "}")) {
                $bracket = -1;
            }

            if ($bracket == -1) {
                array_push($vars, implode("", $currentVarName));
                $currentVarName = [];
                $bracket = 0;
            }

            if ($bracket == 2) {
                if ($row[$i] != "{") {
                    array_push($currentVarName, $row[$i]);
                }
            }

        }

        foreach ($vars as $var) {
            $this->_code[$line] = Str::replace($this->_code[$line], ["{{" .$var . "}}" => "<?php echo " . trim($var) . " ?>"]);
        }

    }

    //*******All synatx*************

    private function endforeach ($line) {
        $this->_code[$line] = "<?php endforeach; ?>";
    }

    private function foreach ($line, $params) {
        $this->_code[$line] = "<?php foreach" . implode(" ", $params) . " ?>";
    }

    private function endif ($line) {
        $this->_code[$line] = "<?php endif; ?>";
    }

    private function else ($line) {
        $this->_code[$line] = "<?php else: ?>";
    }

    private function elseif ($line, $params) {
        $this->_code[$line] = "<?php elseif" . implode(" ", $params) . " ?>";
    }

    private function if ($line, $params) {
        $this->_code[$line] = "<?php if" . implode(" ", $params) . " ?>";
    }

    private function includes ($line, $params) {
        if (count($params) > 1) {
            die("Error in compilation. Wrong parametr for include.");
        }

        $params = trim(Str::replace($params[0], ["/" => "."]));
        $this->_code[$line] = "<?php require_once(\"{$params}\" . \".ctemp.php\"); ?>";
        array_push($this->_includes, $params);
    }

}