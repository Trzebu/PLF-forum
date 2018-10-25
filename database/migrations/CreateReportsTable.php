<?php
namespace DataBase\Migrations;
use Libs\DataBase\TableCreator;
use Libs\DataBase\DataBase as DB;

/**
* Run the migrations.
*
* Auto created at: 2018-09-24 18:32:24
*
* PHP Light Framework Migration File.
*
*/

class CreateReportsTable extends TableCreator {

    protected $tableName = "reports";

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
        $this->int("user_id")->notNullable();
        $this->int("content_id")->notNullable();
        $this->int("parent")->nullable();
        $this->int("status", 2)->default(0);
        $this->int("mod_id")->nullable();
        $this->string("content_type")->nullable();
        $this->text("reason");
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