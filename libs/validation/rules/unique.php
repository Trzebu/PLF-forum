<?php

namespace Libs\Validation\Rules;

use Libs\DataBase\DataBase as DB;
use Libs\Validation\Rule;
use Libs\Str;

class Unique extends Rule {

    protected function unique ($value) {
        if ($this->check($value)) {
            $this->addError($value);
        }
    }

    private function check ($value) {
        return (bool) DB::instance()->table($value)->where($this->__input, "=", $this->__fields[$this->__input])->numRow() > 0;
    }

    private function addError () {
        $this->error(Str::replace(trans("validation.unique"), [
            ":attribute" => $this->__attribute
        ]));
    }

}