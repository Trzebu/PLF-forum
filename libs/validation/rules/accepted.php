<?php

namespace Libs\Validation\Rules;

use Libs\Validation\Rule;
use Libs\Str;

class Accepted extends Rule {

    protected function accepted () {
        if (!isset($this->__fields[$this->__input])) {
            $this->addError();
        }
    }

    private function addError () {
        $this->error(Str::replace(trans("validation.accepted"), [
            ":attribute" => $this->__attribute
        ]));
    }

}