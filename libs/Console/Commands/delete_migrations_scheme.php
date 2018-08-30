<?php

namespace Libs\Console\Commands;
use Libs\Console\CommandInterface;
use Libs\Console\Commands;

class delete_migrations_scheme implements CommandInterface {

    private $_commands;

    public function __construct (Commands $commands) {
        $this->_commands = $commands;
    }

    public function execute ($params) {
        $this->_commands->delete_migrations_scheme($params);
    }

}