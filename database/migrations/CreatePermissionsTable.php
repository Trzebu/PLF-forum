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

class CreatePermissionsTable extends TableCreator {

    protected $tableName = "permissions";

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
        $this->string("name", 100);
        $this->text("permissions");

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
        
        DB::instance()->table($this->tableName)->insert([
            "name" => "User",
            "permissions" => '{"admin":0,"moderator":0}'
        ]);

        DB::instance()->table($this->tableName)->insert([
            "name" => "Administrator",
            "permissions" => '{"admin":1,"moderator":1}'
        ]);
        
        DB::instance()->table($this->tableName)->insert([
            "name" => "Moderator",
            "permissions" => '{"admin":0,"moderator":1}'
        ]);

    }

}