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

    $app_setting_class_name = $dynamic_match["app_name"] . "\\app_setting";
    $app_setting = new $app_setting_class_name();

    $special_actions = $app_setting::SPECIAL_ACTIONS;

    if ($dynamic_match["controller_type"] === "SPECIAL")
    {
        //print_r(explode(".", $special_actions[$dynamic_match["special_flag"]][1]));
        $dynamic_match["controller_name"] = explode(".", $special_actions[$dynamic_match["special_flag"]][1])[0];
        $dynamic_match["action_name"] = explode(".", $special_actions[$dynamic_match["special_flag"]][1])[1];
    }
    else
    {
    }

    // Filter redirect.
    if ($dynamic_match["method"] != "")
    {
        // $method != "", need redirct.
        if ($dynamic_match["method"] === "301")
        {
            //header($_SERVER["SERVER_PROTOCOL"] . "404 Not Found");
            header("Location: " . $url_parser->get($dynamic_match["target"], array(), ""), TRUE, 301);
            exit();
        }
        else if ($dynamic_match["method"] === "302")
        {
            header("Location: " . $url_parser->get($dynamic_match["target"], array(), ""), TRUE, 302);
            exit();
        }
        else
        {
        }
    }
    else
    {
    }

    $controller_class_name = $app_setting::APP_SPACE_NAME . "\\controllers\\" . str_replace("/", "\\", $dynamic_match["controller_name"]);
    $controller = new $controller_class_name();
    $result = $controller->$dynamic_match["action_name"]($dynamic_match["parameters"]);

    /*
    print_r("<pre>");
    //var_dump($controller->config);
    //print_r("<hr />");
    //var_dump($controller->authentication);
    //print_r("<hr />");
    //print_r($result);
    //print_r("<hr />");
    print_r("</pre>");
    exit();
    */

    $view_class_name = $app_setting::APP_SPACE_NAME . "\\views\\" . str_replace("/", "\\", $result["view_name"]);
    $view = new $view_class_name();
    $view->layout($result);
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
