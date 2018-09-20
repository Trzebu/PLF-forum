<?php

namespace Libs\Validation;

use Libs\Validation\Validation;

abstract class Rule {

    protected $__input = "";
    protected $__attribute = "";
    protected $__fields = [];
    protected $__currentMethod = "";
    private $_methods = [];

    public function __construct ($methods) {
        $this->__input = Validation::currentInputGetter();
        $this->__attribute = Validation::attributeNameGetter();
        $this->__fields = Validation::fieldsGetter();
        $this->_methods = $methods;
        $this->executeMethods();
    }

    private function executeMethods () {

        foreach ($this->_methods as $method) {
            $func = "{$method['method']}";
            $this->__currentMethod = $method["method"];
            $this->$func($method['argument']);
        }

    }

    protected function error ($error) {
        Validation::addError($this->__input, $error);
    }

}