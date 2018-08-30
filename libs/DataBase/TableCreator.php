<?php

namespace Libs\DataBase;
use Libs\DataBase\DataBase;
use Exception;

class TableCreator extends DataBase {

    /**
     * Table name.
     * @var string
     */

    protected $tableName = null;

    /**
     * All SQL fields.
     * @var array
     */

    private $_fields = [];

    /**
     * SQL syntax given at the end of request.
     * @var array
     */

    private $_atEnd = [];

    /**
     * Default columns length by type.
     * @var array
     */

    private $_default = [
        "int" => 11,
        "varchar" => 50,
    ];

    public function __construct () {
        parent::__construct();
    }

    protected function increments ($name) {
        $this->int($name);
        $this->notNullable();
        $this->autoIncrement();
        $this->primary($name);
    }

    protected function time () {
        $this->timestamp("created_at")->currentTimestamp();
        $this->timestamp("updated_at")->onUpdateTimestamp();
    }

    /**
     * SQL syntax.
     *
     */

    protected function int($name, $length = null) {
        $length = $length === null ? $this->_default["int"] : $length;
        $this->add("`{$name}`");
        $this->extend("INT({$length})");
        return $this;
    }

    protected function string ($name, $length = null) {
        $length = $length === null ? $this->_default["varchar"] : $length;
        $this->add("`{$name}`");
        $this->extend("VARCHAR({$length})");
        return $this;
    }

    protected function text ($name) {
        $this->add("`{$name}`");
        $this->extend("TEXT");
        return $this;
    }

    protected function bigInt ($name) {
        $this->add("`{$name}`");
        $this->extend("BIGINT");
        return $this;
    }

    protected function timestamp ($name) {
        $this->add("`{$name}`");
        $this->extend("TIMESTAMP");
        return $this;
    }

    protected function default ($value) {
        $this->extend("DEFAULT '{$value}'");
        return $this;
    }

    protected function onUpdateTimestamp () {
        $this->currentTimestamp();
        $this->extend("ON UPDATE CURRENT_TIMESTAMP");
        return $this;
    }

    protected function currentTimestamp () {
        $this->extend("DEFAULT CURRENT_TIMESTAMP");
        return $this;
    }

    protected function primary ($key) {
        $this->addEnd("PRIMARY KEY (`{$key}`)");
        return $this;
    }

    protected function autoIncrement () {
        $this->extend("AUTO_INCREMENT");
        return $this;
    }

    protected function nullable () {
        $this->extend("NULL DEFAULT NULL");
        return $this;
    }

    protected function notNullable () {
        $this->extend("NOT NULL");
        return $this;
    }

    /******/

    protected function prepare () {
        $fields = array_merge($this->_fields, $this->_atEnd);
        $imploded_fields = [];

        foreach ($fields as $field) {
            array_push($imploded_fields, implode(" ", $field));
        }

        $sql = "CREATE TABLE `{$this->tableName}` (" . implode(",", $imploded_fields) . ");";
        return $this->query($sql);
    }

    protected function exists () {
        try {
            $result = $this->_pdo->query("SELECT 1 FROM {$this->tableName} LIMIT 1");
        } catch (Exception $e) {
            return false;
        }

        return (bool) $result !== false;
    }

    private function last () {
        return (int) count($this->_fields) - 1;
    }

    private function extend ($field) {
        array_push($this->_fields[$this->last()], $field);
    }

    private function addEnd ($field) {
        array_push($this->_atEnd, [$field]);
    }

    private function add ($name) {
        array_push($this->_fields, []);
        $this->extend($name);
    }

}