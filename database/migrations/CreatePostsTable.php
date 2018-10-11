<?php
namespace DataBase\Migrations;
use Libs\DataBase\TableCreator;
use Libs\DataBase\DataBase as DB;

/**
* Run the migrations.
*
* Auto created at: 2018-09-03 19:56:03
*
* PHP Light Framework Migration File.
*
*/

class CreatePostsTable extends TableCreator {

    protected $tableName = "posts";

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
        $this->int("parent", 10)->nullable();
        $this->int("status", 10)->nullable();
        $this->int("sticky", 1)->nullable();
        $this->int("category", 10)->notNullable();
        $this->int("user_id", 10)->notNullable();
        $this->int("visits", 50)->default(1);
        $this->string("subject", 250)->notNullable();
        $this->text("contents")->notNullable();
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