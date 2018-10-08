<?php
namespace DataBase\Migrations;
use Libs\DataBase\TableCreator;
use Libs\DataBase\DataBase as DB;

/**
* Run the migrations.
*
* Auto created at: 2018-09-01 19:27:01
*
* PHP Light Framework Migration File.
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
        $this->string("username", 30)->notNullable();
        $this->string("password", 70)->notNullable();
        $this->string("email", 100)->notNullable();
        $this->int("permissions", 5)->default(1);
        $this->int("avatar", 50)->nullable();
        $this->string("full_name", 255)->nullable();
        $this->string("city", 255)->nullable();
        $this->string("country", 255)->nullable();
        $this->string("www", 255)->nullable();
        $this->text("about");
        $this->text("signature");
        $this->int("warnings")->default(0);
        $this->string("remember_me", 255)->nullable();
        $this->string("ip", 20)->notNullable();
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