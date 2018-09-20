<?php

namespace Libs\Validation\Rules;

use Libs\DataBase\DataBase as DB;
use Libs\Validation\Rule;
use Libs\Str;

class Same extends Rule {

    protected function same ($value) {
        if ($this->__fields[$this->__input] != $this->__fields[$value]) {
            $this->addError($value);
        }
    }

    private function addError ($value) {
        $this->error(Str::replace(trans("validation.same"), [
            ":attribute" => $this->__attribute,
            ":other" => $value
        ]));
    }

}