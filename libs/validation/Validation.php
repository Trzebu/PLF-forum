<?php

namespace Libs\Validation;
use Libs\Token;
use Libs\Translate;
use Libs\Str;
use Libs\DataBase\DataBase as DB;

class Validation {

    private static $_fields = [];
    private static $_attribute = "";
    private static $_currentInput = "";
    private static $_rules = [];
    private static $_currentRule = null;
    private static $_errors = [];

    private function __construct ($fields, $rules) {
        self::$_fields = $fields;
        self::$_rules = $rules;

        self::checkRules();
    }

    private function checkRules () {

        foreach (self::$_rules as $rule => $value) {

            self::$_attribute = is_array($value) ? $value[1] : $rule;
            self::$_currentInput = $rule;
            $rules = explode("|", is_array($value) ? $value[0] : $value);

            foreach ($rules as $rule) {
                $methods = [];
                foreach (explode(">", $rule) as $rule) {
                    $rule = explode(":", $rule);

                    array_push($methods, [
                        "method" => $rule[0],
                        "argument" => isset($rule[1]) ? $rule[1] : (unset) null
                    ]);
                }

                $ruleName = "Libs\Validation\Rules\\" . $methods[0]["method"];

                self::$_currentRule = new $ruleName($methods);
            }

        }

    }

    public static function start ($fields, $rules) {
        new Validation($fields, $rules);
    }

    public static function currentInputGetter () {
        return self::$_currentInput;
    }

    public static function attributeNameGetter () {
        return self::$_attribute;
    }

    public static function fieldsGetter () {
        return self::$_fields;
    }

    public static function errorsGetter () {
        return self::$_errors;
    }

    public static function addError ($inputName, $error) {
        array_push(self::$_errors, [$inputName, $error]);
    }

    public static function check () {
        return (bool) count(self::$_errors) == 0;
    }


}