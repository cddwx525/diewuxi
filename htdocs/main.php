<?php
define("MAIN_SCRIPT", basename(__FILE__));
define("ROOT_PATH", __DIR__);
define("CONFIG_PATH", ROOT_PATH . "/config");
define("CORE_PATH", ROOT_PATH . "/core");
define("RUNTIME_PATH", ROOT_PATH . "/runtime");
define("APP_PATH", ROOT_PATH . "/apps");

include CONFIG_PATH . "/config.php";
include CORE_PATH . "/php_setting.php";
include CORE_PATH . "/url_parser.php";
include CORE_PATH . "/start_app.php";
include CORE_PATH . "/db_method.php";

$php_setting = new php_setting();
$php_setting->run();


//$original_string = $_SERVER["QUERY_STRING"];
$original_string = $_SERVER["REQUEST_URI"];

$url_parser = new url_parser();

if (STATIC_FILE === TRUE)
{
    /*
     * For php build in server router mode.
     */
    $static_match = $url_parser->static_match($original_string);
    if ($static_match)
    {
        return FALSE;
    }
}
else
{
}

$dynamic_match = $url_parser->dynamic_match($original_string);

/*
print "<pre>";
print_r($dynamic_match);
print "</pre>";
exit();
 */

$app_name = $dynamic_match["app_name"];

$app_class_name = $app_name . "\\app_main";
$app = new $app_class_name();
$app->run($dynamic_match);
?>
