<?php

namespace Libs\Validation;
use Libs\Token;
use Libs\Translate;
use Libs\Str;
use Libs\DataBase\DataBase as DB;

class Validation {

    private $_errors = [];

    public function __construct ($post, $filters) {
        $this->execute($post, $filters);
    }

    private function execute ($post, $filters) {
        //Standard 
        $token_check = false;

        foreach ($filters as $input => $values) {
            $attribute = is_array($values) ? $values[1] : $input;
            $values = is_array($values) ? $values[0] : $values;
            $values = explode("|", $values);

            foreach ($values as $key) {
                $key = explode(":", $key);
                $value = isset($key[1]) ? $key[1] : null;

                switch ($key[0]) {
                    case "accepted":
                        if (!isset($post[$input])) {
                            $this->addError($input, Str::replace(Translate::get("validation.accepted"), [
                                ":attribute" => $attribute
                            ]));
                        }
                    break;
                    case "token":
                        if (isset($post[$input])) {
                            $token_check = true;
                            if (!Token::check($input, $post[$input])) {
                                $this->addError($input, Translate::get("validation.token"));
                            }
                        }
                    break;
                    case "min_string":
                        if (strlen($post[$input]) < $value) {
                            $this->addError($input, Str::replace(Translate::get("validation.min.string"), [
                                ":attribute" => $attribute,
                                ":min" => $value
                            ]));
                        }
                    break;
                    case "min_numeric":
                        if (intval($post[$input]) < $value) {
                            $this->addError($input, Str::replace(Translate::get("validation.min.numeric"), [
                                ":attribute" => $attribute,
                                ":min" => $value
                            ]));
                        }
                    break;
                    case "max_string":
                        if (strlen($post[$input]) > $value) {
                            $this->addError($input, Str::replace(Translate::get("validation.max.string"), [
                                ":attribute" => $attribute,
                                ":max" => $value
                            ]));
                        }
                    break;
                    case "max_numeric":
                        if (intval($post[$input]) > $value) {
                            $this->addError($input, Str::replace(Translate::get("validation.max.numeric"), [
                                ":attribute" => $attribute,
                                ":max" => $value
                            ]));
                        }
                    break;
                    case "numeric":
                        if (!ctype_digit($post[$input])) {
                            $this->addError($input, Str::replace(Translate::get("validation.numeric"), [
                                ":attribute" => $attribute
                            ]));
                        }
                    break;
                    case "string":
                        if (!is_string($post[$input])) {
                            $this->addError($input, Str::replace(Translate::get("validation.string"), [
                                ":attribute" => $attribute
                            ]));
                        }
                    break;
                    case "alpha":
                        if (!ctype_alpha($post[$input])) {
                            $this->addError($input, Str::replace(Translate::get("validation.alpha"), [
                                ":attribute" => $attribute
                            ]));
                        }
                    break;
                    case "alpha_num":
                        if (!ctype_alnum($post[$input])) {
                            $this->addError($input, Str::replace(Translate::get("validation.alpha_num"), [
                                ":attribute" => $attribute
                            ]));
                        }
                    break;
                    case "same":
                        $other = is_array($filters[$value]) ? $filters[$value][1] : $value;
                        if ($post[$input] != $post[$value]) {
                            $this->addError($input, Str::replace(Translate::get("validation.same"), [
                                ":attribute" => $attribute,
                                ":other" => $other
                            ]));
                        }
                    break;
                    case "required":
                        if (empty($post[$input])) {
                            $this->addError($input, Str::replace(Translate::get("validation.required"), [
                                ":attribute" => $attribute
                            ]));
                        }
                    break;
                    case "unique":
                        if (DB::instance()->table($value)->where($input, "=", $post[$input])->get(["id"])->count() > 0) {
                            $this->addError($input, Str::replace(Translate::get("validation.unique"), [
                                ":attribute" => $attribute
                            ]));
                        }
                    break;
                }
            }

        }

        if (!$token_check) {
            dd("You must set the CSRF protection token!");
        }

    }

    private function addError ($inputName, $error) {
        array_push($this->_errors, [$inputName, $error]);
    }

    public function check () {
        return (bool) count($this->_errors) == 0;
    }

    public function errors () {
        return count($this->_errors) > 0 ? $this->_errors : null;
    }

}