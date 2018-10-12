<?php

require_once(__ROOT__ . '/config/config.php');
require_once(__ROOT__ . '/libs/functions/auto_load.php');
require_once(__ROOT__ . '/libs/functions/route.php');
require_once(__ROOT__ . '/libs/functions/dd.php');
require_once(__ROOT__ . '/libs/functions/auth.php');
require_once(__ROOT__ . '/libs/functions/trans.php');
require_once(__ROOT__ . '/libs/functions/token.php');
require_once(__ROOT__ . '/libs/functions/stripBbCodeTags.php');
require_once(__ROOT__ . '/libs/functions/config.php');

//Loading system registry

Libs\Config::loadRegistry();

$app = new Libs\App;

