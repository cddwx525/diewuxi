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

function start_process($url_parser, $original_string)
{
    $dynamic_match = $url_parser->dynamic_match($original_string);

    /*
    print "<pre>";
    print_r($dynamic_match);
    print_r("<hr />");
    //print_r($url_parser->url_map);
    //print "<hr />";
    //print_r($url_parser->get_full_url_map());
    //print "<hr />";
    //print_r($url_parser->get(array("blog", "admin/home.show", ""), array(), ""));
    //print "<hr />";
    print "</pre>";
    exit();
     */

    $app_class_name = $dynamic_match["app_name"] . "\\app_main";
    $app = new $app_class_name();
    $app->run($dynamic_match);
}

if (STATIC_FILE === TRUE)
{
    /*
     * Use php build in server to route static file.
     */
    $static_match = $url_parser->static_match($original_string);
    if ($static_match)
    {
        // Static file.
        return FALSE;
    }
    else
    {
        // Dynamic url.
        start_process($url_parser, $original_string);
    }
}
else
{
    // Use web server to route static file.
    start_process($url_parser, $original_string);
}
?>
