<?php

namespace Libs\Validation\Rules;

use Libs\DataBase\DataBase as DB;
use Libs\Validation\Rule;
use Libs\Str as Stri;

class Str extends Rule {

    protected function str () {
        if (!is_string($this->__fields[$this->__input])) {
            $this->addError("");
        }
    }

    protected function min ($value) {
        if (strlen($this->__fields[$this->__input]) < $value) {
            $this->addError($value);
        }
    }

    protected function max ($value) {
        if (strlen($this->__fields[$this->__input]) > $value) {
            $this->addError($value);
        }
    }

    private function addError ($value) {
        $this->error(Stri::replace(trans("validation.string.{$this->__currentMethod}"), [
            ":attribute" => $this->__attribute,
            ":{$this->__currentMethod}" => $value
        ]));
    }

}