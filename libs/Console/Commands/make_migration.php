<?php

namespace Libs\Console\Commands;
use Libs\Console\CommandInterface;
use Libs\Console\Commands;

class make_migration implements CommandInterface {

    private $_commands;

    public function __construct (Commands $commands) {
        $this->_commands = $commands;
    }

    public function execute ($params) {
        $this->_commands->make_migration();
    }

}