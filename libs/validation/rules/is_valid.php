<?php

namespace Libs\Validation\Rules;

use Libs\Validation\Rule;
use Libs\Str;

class Is_valid extends Rule {

    protected function is_valid () {
        return;
    }

    protected function email () {
        if (filter_var($this->__fields[$this->__input], FILTER_VALIDATE_EMAIL) === false) {
            $this->addError();
        }
    }

    protected function url () {
        if (filter_var($this->__fields[$this->__input], FILTER_VALIDATE_URL) === FALSE) {
            $this->addError();
        }   
    }

    private function addError () {
        $this->error(Str::replace(trans("validation.is_valid.{$this->__currentMethod}"), [
            ":attribute" => $this->__attribute
        ]));
    }

}