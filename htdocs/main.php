<?php
define("DEBUG", TRUE);
define("STATIC_FILE", TRUE);

define("MAIN_SCRIPT", basename(__FILE__));
define("ROOT_PATH", __DIR__);
define("CONFIG_PATH", ROOT_PATH . "/config");
define("CORE_PATH", ROOT_PATH . "/swdf");
define("RUNTIME_PATH", ROOT_PATH . "/runtime");
define("APP_PATH", ROOT_PATH . "/apps");

require CORE_PATH . "/swdf.php";

$config = require CONFIG_PATH . "/config.php";

$application = new swdf\base\application($config);
$application->run();
?>
