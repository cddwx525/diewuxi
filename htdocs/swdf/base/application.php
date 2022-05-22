<?php
namespace swdf\base;

use swdf\helpers\url;

class application
{
    // Global config.
    public $config = NULL;
    public $apps = NULL;
    public $main_app = NULL;
    public $url_map = NULL;


    // App properties from config file.
    public $name = NULL;
    public $title = NULL;
    public $version = NULL;
    public $params = NULL;
    public $db_id = NULL;
    public $meta_table = NULL;
    public $sql = NULL;

    public $special_actions = array();


    // App properties runtime.
    public $db = NULL;
    public $router = NULL;
    public $request = NULL;

    public $data = NULL;


    /**
     *
     *
     */
    public function __construct($config)
    {
        \swdf::$app = $this;
        $this->configure($config);
    }


    /**
     *
     *
     */
    public function run()
    {
        $request_uri = $_SERVER["REQUEST_URI"];
        $router = $this->get_router($request_uri);

        if ($router === FALSE)
        {
            return FALSE;
        }
        else
        {
        }

        $this->configure_app($router);

        $this->response($router);
    }


    /**
     *
     *
     */
    private function configure($config)
    {
        $this->config = $config;

        $url_map = array();
        $apps = array();
        foreach ($config["apps"] as $app_name => $value)
        {
            if ($app_name === $config["main_app"])
            {
                $url_map = array_merge($url_map, require APP_PATH . "/" . $app_name . "/urls.php");
            }
            else
            {
                $url_map[] = array(
                    "^/" . $value["url_prefix"],
                    array("/" . $value["url_prefix"]),
                    array(""),
                    require APP_PATH . "/" . $app_name . "/urls.php",
                );
            }

            $apps[$app_name] = require APP_PATH . "/" . $app_name . "/config.php";
        }

        $this->url_map = $url_map;
        $this->apps = $apps;
        $this->main_app = $apps[$config["main_app"]];
    }


    /**
     *
     *
     */
    private function configure_app($router)
    {
        foreach ($this->apps[$router["app_name"]] as $name => $value)
        {
            $this->$name = $value;
        }

        $this->router = $router;
        $this->request = $router["parameters"];

        if (! is_null($this->db_id))
        {
            $this->db = $this->get_db($this->db_id["host"], $this->db_id["name"], $this->db_id["user"], $this->db_id["password"]);

            $this->init_tables($this->meta_table, $this->sql);
        }
        else
        {
        }
    }


    /**
     *
     *
     */
    private function get_router($request_uri)
    {
        if (STATIC_FILE === TRUE)
        {
            // Use php build in server to route static file.
            $static_match = $this->static_match($request_uri);
            if ($static_match)
            {
                // Static file.
                return FALSE;
            }
            else
            {
                // Dynamic url.
                //$this->response($request_uri);
                return $this->dynamic_match($request_uri);
            }
        }
        else
        {
            // Use web server to route static file.
            //$this->response($request_uri);
            return $this->dynamic_match($request_uri);
        }
    }


    /**
     *
     *
     */
    private function response($router)
    {
        // Special router.
        if ($router["controller_type"] === "special")
        {
            $special_actions = $this->apps[$this->name]["special_actions"];
            $router["controller_name"] = explode(".", $special_actions[$router["special_flag"]][1])[0];
            $router["action_name"] = explode(".", $special_actions[$router["special_flag"]][1])[1];
        }
        else
        {
        }

        /*
        print("<pre>");
        print_r($router);
        print("</pre>");
        exit();
        */


        // Filter redirect.
        if (
            ($router["method"] === "301") ||
            ($router["method"] === "302")
        )
        {
            header("Location: " . url::get($router["target"], array(), ""), TRUE, $router["method"]);
            exit();
        }
        else
        {

            $controller_class = $this->name . "\\controllers\\" . str_replace("/", "\\", $router["controller_name"]);
            $controller = new $controller_class();

            $filter_result = $controller->filter();
            if ($filter_result === TRUE)
            {
                //$result = $controller->$router["action_name"]();
                $action_name=$router["action_name"];
                $result = $controller->$action_name();
            }
            else
            {
                $result = $filter_result;
            }


            // result[0]: view name
            // result[1]: data array
            $view_class = $this->name . "\\views\\" . str_replace("/", "\\", $result[0]);
            $view = new $view_class($result[1]);

            // Output mode.
            if ($router["method"] === "text")
            {
                $view->output_text();
            }
            else if ($router["method"] === "")
            {
                $view->output_html();
            }
            else
            {
            }
        }
    }


    /**
     *
     *
     */
    private function static_match($request_uri)
    {
        /*
         * Static file check.
         * /apps/{app_name}/static/{folder}/path/to/file$
         * /favicon.ico
         * /robots.txt
         */

        $static_match = preg_match("%^/apps/\w+/static/\w+(/\w+)*/.*$%", $request_uri);
        $static_match_ico = preg_match("%^/favicon\.ico$%", $request_uri);
        $static_match_robot = preg_match("%^/robots\.txt$%", $request_uri);

        if (
            ($static_match === 1) ||
            ($static_match_ico === 1) ||
            ($static_match_robot === 1)
        )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    /**
     *
     *
     */
    private function dynamic_match($request_uri)
    {
        if (preg_match("%^(?P<final_string>.*)\?i=\d+$%", $request_uri, $matches) === 1)
        {
            header("Location: " . url::root_url() . $matches["final_string"], TRUE, 301);
            exit();
        }
        else
        {
            return $this->parse_uri($this->url_map, $request_uri, $request_uri);
        }

    }


    /**
     *
     * Recursive match URI.
     */
    private function parse_uri($url_map, $target_string, $request_uri)
    {
        foreach ($url_map as $one_map)
        {
            if (preg_match("%" . $one_map[0] . "%", $target_string, $matches) === 1)
            {
                if (is_array($one_map[3][0]) === TRUE)
                {
                    $new_string = substr($target_string, strlen($matches[0]));
                    // The return here is necessary.
                    return $this->parse_uri($one_map[3], $new_string, $request_uri);
                }
                else
                {
                    $match_variable = array();
                    foreach ($one_map[2] as $one_match_varibale)
                    {
                        if ($one_match_varibale != "")
                        {
                            $match_variable[$one_match_varibale] = $matches[$one_match_varibale];
                        }
                    }
                    return array(
                        "app_name" => $one_map[3][0],
                        "controller_type" => $one_map[3][1],
                        "special_flag" => "",
                        "controller_name" => $one_map[3][2],
                        "action_name" => $one_map[3][3],
                        "method" => $one_map[3][4],
                        "target" => $one_map[3][5],
                        "parameters" => array(
                            "get" => $match_variable,
                            "post" => $_POST,
                            "file" => $_FILES,
                            "url" => url::root_url() . $request_uri,
                        ),
                    );
                }
            }
            else
            {
            }
        }

        // Not match.
        return array(
            "app_name" => $this->config["main_app"],
            "controller_type" => "special",
            "special_flag" => "not_found",
            "controller_name" => "",
            "action_name" => "",
            "method" => "",
            "target" => "",
            "parameters" => array(
                "get" => array(),
                "post" => $_POST,
                "file" => $_FILES,
                "url" => url::root_url() . $request_uri,
            ),
        );
    }


    /**
     *
     *
     */
    private function get_db($host, $dbname, $user, $pass)
    {
        try
        {
            $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $host, $dbname);

            $db = new \PDO(
                    $dsn,
                    $user,
                    $pass,
                    array(
                        \PDO::ATTR_PERSISTENT => TRUE,
                    )
                );

            $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            //$db->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, FALSE);
            //$db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, FALSE);

            return $db;
        }
        catch (\PDOException $e)
        {
            print "Error in \"application->get_db()\":" . $e->getMessage() . "<br/>";
            exit();
        }
    }


    /**
     *
     *
     */
    private function init_tables($meta_table, $sql)
    {   
        try
        {
            $this->db->query("SELECT * FROM `" . $meta_table . "`");
        }
        catch (\PDOException $e)
        {
            try
            {
                $this->db->query($sql);
            }
            catch (\PDOException $e)
            {
                print "Error!: " . $e->getMessage() . "<br/>";
                exit();
            }
        }
    }
}
?>
