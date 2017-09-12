<?php
class start_app
{
    public function set_app($app_setting)
    {
        $app_setting->set_app();
    }

    public function route($dynamic_match, $app_setting)
    {
        $url = new \url_parser();

        $special_controllers = $app_setting->special_controllers();

        $method = $dynamic_match["method"];
        $target = $dynamic_match["target"];
        $parameters = array(
            "get" => $dynamic_match["url_parameters"],
            "post" => $_POST,
            "url" => $dynamic_match["url"],
        );

        if ($dynamic_match["controller_type"] === "SPECIAL")
        {
            $controller_name = $special_controllers[$dynamic_match["controller_name"]];
        }
        else if ($dynamic_match["controller_type"] === "COMMON")
        {
            $controller_name = $dynamic_match["controller_name"];
        }
        else
        {
        }

        if ($method != "")
        {
            if ($method === "301")
            {
                /*
                 * $method != "", need redirct.
                 */
                //header($_SERVER["SERVER_PROTOCOL"] . "404 Not Found");
                header("Location: " . $url->get($target, array(), ""), TRUE, 301);
                exit();
            }
            else if ($method === "302")
            {
                header("Location: " . $url->get($target, array(), ""), TRUE, 302);
                exit();
            }
            else
            {
            }
        }
        else
        {
            $controller_class_name = APP_NAME . "\\controllers\\" . str_replace("/", "\\", $controller_name);
            $controller = new $controller_class_name();
            $controller->init();
            $result = $controller->operate($parameters);

            $view_class_name = APP_NAME . "\\views\\" . str_replace("/", "\\", $result["view_name"]);
            $view = new $view_class_name();
            $view->layout($result);
        }
    }
}
?>
