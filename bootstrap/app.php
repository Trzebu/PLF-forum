<?php

require_once(__ROOT__ . '/config/config.php');
require_once(__ROOT__ . '/libs/functions/auto_load.php');
require_once(__ROOT__ . '/libs/functions/route.php');
require_once(__ROOT__ . '/libs/functions/dd.php');
require_once(__ROOT__ . '/libs/functions/auth.php');
require_once(__ROOT__ . '/libs/functions/trans.php');

//Loading system registry

$configs = Libs\DataBase\DataBase::instance()->table("system_registry")->get()->results();

foreach ($configs as $conf) {
    $GLOBALS['constants'] = array_merge($GLOBALS['constants'], [$conf->registry_name => $conf->value]);
}

$app = new Libs\App;

