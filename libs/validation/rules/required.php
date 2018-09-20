<?php

namespace Libs\Validation\Rules;

use Libs\Validation\Rule;
use Libs\Str;

class Required extends Rule {

    protected function required () {
        if ($this->isEmpty() || $this->isEmptyFile()) {
            $this->addError();
        }
    }

    private function isEmpty () {
        return (bool) empty($this->__fields[$this->__input]);
    }

    private function isEmptyFile () {
        if (!isset($this->__fields[$this->__input])) {
            return false;
        }

        if (!isset($this->__fields[$this->__input]["name"])) {
            return false;
        }

        if (strlen($this->__fields[$this->__input]["name"]) == 0) {
            return true;
        }
    }

    private function addError () {
        $this->error(Str::replace(trans('validation.required'), [
            ":attribute" => $this->__attribute
        ]));
    }

}