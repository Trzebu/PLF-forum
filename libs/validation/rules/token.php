<?php

namespace Libs\Validation\Rules;

use Libs\Validation\Rule;
use Libs\Token as TokenCheck;

class Token extends Rule {

    protected function token () {
        if (!TokenCheck::check($this->__input, $this->__fields[$this->__input])) {
            $this->addError($value);
        }
    }

    private function addError ($value) {
        $this->error(trans("validation.token"));
    }

}