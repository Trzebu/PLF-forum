<?php
namespace DataBase\Migrations;
use Libs\DataBase\TableCreator;
use Libs\DataBase\DataBase as DB;

/**
* Run the migrations.
*
* Auto created at: 2018-08-15 18:52:15
*
* PHP Light Framework Migration File.
*
* Required to run demo.
*
*/

class CreateUsersTable extends TableCreator {

    protected $tableName = "users";

    public function create () {

        /**
         * Checking that table exists.
         *
         * @return bool
         */

        if ($this->exists()) {
            return;
        }

        /**
         * 
         * Table fields.
         * 
         */

        $this->increments("id");
        $this->string("login");
        $this->string("password", 100);
        $this->string("name", 100)->nullable();
        $this->string("last_name", 100)->nullable();
        $this->string("city", 100)->nullable();
        $this->string("remember_me", 100)->nullable();
        $this->int("permissions")->default(1);
        $this->time();

        /**
         * 
         * Creating table based on fields from this scheme.
         * 
         * @return bool
         */

        $result = $this->prepare();
        $this->defaultInsert();

        return $result;
    }

    private function defaultInsert () {

        /**
         * 
         * Here you can set what will be inserted into the table after it is created.
         * 
         */

        // DB::instance()->table($this->tableName)->insert([
        //     "field" => "value"
        // ]);

    }

}