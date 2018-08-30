<?php
namespace DataBase\Migrations;
use Libs\DataBase\TableCreator;
use Libs\DataBase\DataBase as DB;

/**
* Run the migrations.
*
* Auto created at: {data}
*
* PHP Light Framework Migration File.
*
*/

class Create{upper_table_name}Table extends TableCreator {

    protected $tableName = "{table_name}";

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