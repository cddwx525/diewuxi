<?php
class start_app
{
    public function route($dynamic_match, $app_setting)
    {
        $url = new \url_parser();

        $special_actions = $app_setting::SPECIAL_ACTIONS;

        if ($dynamic_match["controller_type"] === "SPECIAL")
        {
            $dynamic_match["controller_name"] = $special_actions[$dynamic_match["special_flag"]][0];
            $dynamic_match["action_name"] = $special_actions[$dynamic_match["special_flag"]][1];
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
                header("Location: " . $url->get($dynamic_match["target"], array(), ""), TRUE, 301);
                exit();
            }
            else if ($dynamic_match["method"] === "302")
            {
                header("Location: " . $url->get($dynamic_match["target"], array(), ""), TRUE, 302);
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
}
?>
