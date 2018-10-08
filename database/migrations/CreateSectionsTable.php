<?php
namespace DataBase\Migrations;
use Libs\DataBase\TableCreator;
use Libs\DataBase\DataBase as DB;

/**
* Run the migrations.
*
* Auto created at: 2018-09-02 15:35:02
*
* PHP Light Framework Migration File.
*
*/

class CreateSectionsTable extends TableCreator {

    protected $tableName = "sections";

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
        $this->int("parent", 50)->nullable();
        $this->int("queue", 10)->notNullable();
        $this->int("status", 10)->nullable();
        $this->text("permissions")->nullable();
        $this->text("name");
        $this->text("url_name");
        $this->text("description");

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