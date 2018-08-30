<?php

namespace Libs\Console;
use Libs\Console\Commands;

class Console {

   private $_command = "";

    public function __construct () {
        if (PHP_OS == 'WINNT') {
            echo '$ ';
            $this->_command = stream_get_line(STDIN, 1024, PHP_EOL);
        } else {
            $this->_command = readline('$ ');
        }

        $this->run();

    }

    private function run () {
        $params = explode(" ", $this->_command);
        $this->_command = "Libs\Console\Commands\\$params[0]";
        array_shift($params);

        if (file_exists(__ROOT__ . "/" . $this->_command . ".php")) {
            $this->_command = new $this->_command(new Commands());
            $this->_command->execute($params);
        } else {
            con_log("Unknown command {$this->_command}.");
        }

        self::__construct();
    }

}