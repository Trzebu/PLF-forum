<?php

require_once(__ROOT__ . '/config/config.php');
require_once(__ROOT__ . '/Libs/functions/auto_load.php');
require_once(__ROOT__ . '/Libs/functions/route.php');
require_once(__ROOT__ . '/Libs/functions/dd.php');
require_once(__ROOT__ . '/Libs/functions/auth.php');
require_once(__ROOT__ . '/Libs/functions/trans.php');
require_once(__ROOT__ . '/Libs/functions/token.php');
require_once(__ROOT__ . '/Libs/functions/stripBbCodeTags.php');
require_once(__ROOT__ . '/Libs/functions/config.php');

//Loading system registry

Libs\Config::loadRegistry();

$app = new Libs\App;

