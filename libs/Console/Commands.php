<?php

namespace Libs\Console;
use Libs\Str;

class Commands {

    public function delete_migrations_scheme () {
        con_log("Searching files to delete...");
        $path = __ROOT__ . "/database/migrations";
        if (is_dir($path)) {
            $files = scandir($path);
                   
            foreach ($files as $file) {
                if ($file[0] != ".") {
                    unlink($path . "/{$file}");
                    con_log("Deleted scheme {$file}");
                }
            }

            con_log("All schemes deleted!");

        } else {
            con_log("Data base migration dir no exists!");
        }
    }

    public function create_table ($params) {
        if (isset($params[0]) && strlen($params[0]) > 0) {
            $param = $params[0];
            con_log("Creating Data Base file template: {$param}");
            $template = file_get_contents(__ROOT__ . "/libs/DataBase/CreateTableTemplate.php");
            $template = Str::replace($template, ["{upper_table_name}" => ucfirst($param),
                                                 "{table_name}" => $param,
                                                 "{data}" => date("Y-m-d H:i:d")]);
            $path = __ROOT__ . "/database/migrations/Create" . ucfirst($param) . "Table.php";
            if (!file_exists($path)) {
                $file = fopen($path, 'c');
                fwrite($file, $template);
                fclose($file);
                con_log("File created in {$path}");
            } else {
                con_log(ucfirst($param) . " table scheme already exists.");
            }
        } else {
            con_log("To few arguments for function create_table!");
        }
    }

    public function make_migration () {
        con_log("Making Data Base migration...");
        $path = __ROOT__ . "/database/migrations";
        if (is_dir($path)) {
            $files = scandir($path);
                    
            foreach ($files as $file) {
                if ($file[0] != ".") {
                    $file = explode(".", $file);
                    $file = "database\migrations\\$file[0]";
                    con_log("Running {$file} migration");
                    $class = new $file;
                    $class->create();
                }
            }

            con_log("All migrations done!");

        } else {
            con_log("Data base migration dir no exists!");
        }
    }

    public function close () {
        exit();
    }

}