<?php

namespace Libs\Validation\Rules;

use Libs\DataBase\DataBase as DB;
use Libs\Validation\Rule;
use Libs\Str;

class Num extends Rule {

    protected function num () {
        if (!is_numeric($this->__fields[$this->__input])) {
            $this->addError("");
        }
    }

    protected function min ($value) {
        if ($this->__fields[$this->__input] < $value) {
            $this->addError($value);
        }
    }

    protected function max ($value) {
        if ($this->__fields[$this->__input] > $value) {
            $this->addError($value);
        }
    }

    protected function equals ($value) {
        if ($this->__fields[$this->__input] !== $value) {
            $this->addError($value);
        }
    }

    private function addError ($value) {
        $this->error(Str::replace(trans("validation.integre.{$this->__currentMethod}"), [
            ":attribute" => $this->__attribute,
            ":{$this->__currentMethod}" => $value
        ]));
    }

}