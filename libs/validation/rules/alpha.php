<?php

namespace Libs\Validation\Rules;

use Libs\Validation\Rule;
use Libs\Str;

class Alpha extends Rule {

    protected function alpha ($value) {
        if ($this->$value()) {
            $this->addError($value);
        }
    }

    private function letters () {
        return (bool) !ctype_alpha($this->__fields[$this->__input]);
    }

    private function num () {
        return (bool) !ctype_alnum($this->__fields[$this->__input]);
    }

    private function addError ($value) {
        $this->error(Str::replace(trans("validation.alpha.{$value}"), [
            ":attribute" => $this->__attribute
        ]));
    }

}