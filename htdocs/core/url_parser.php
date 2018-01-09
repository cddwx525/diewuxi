<?php
include CONFIG_PATH . "/urls.php";

class url_parser
{
    public $url_map = array();

    public function __construct()
    {
        $root_urls = new urls();
        $this->url_map = $root_urls->url_map();
    }

    public function static_match($original_string)
    {
        /*
         * Static file check.
         * /apps/{app_name}/static/{folder}/path/to/file$
         * /favicon.ico
         * /robots.txt
         */

        $static_match = preg_match("%^/apps/\w+/static/\w+(/\w+)*/.*$%", $original_string);
        $static_match_ico = preg_match("%^/favicon\.ico$%", $original_string);
        $static_match_robot = preg_match("%^/robots\.txt$%", $original_string);

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

    public function dynamic_match($original_string)
    {
        if (preg_match("%^(?P<final_string>.*)\?i=\d+$%", $original_string, $matches) === 1)
        {
            header("Location: " . $this->root_url() . $matches["final_string"], TRUE, 301);
            exit();
        }
        else
        {
            return $this->parse_uri($this->url_map, $original_string, $original_string);
        }

    }


    /*
     * Get dynamic urls.
     */
    function get($url_record, $parameters, $anchor)
    {
        $one_full_url_record = $this->search_url_record($url_record);

        //print "<pre>";
        //print_r($one_full_url_record);
        //print "</pre>";

        if ($one_full_url_record != FALSE)
        {
            $final_url = array();
            $i = 0;
            foreach ($one_full_url_record[1] as $url_string)
            {
                $final_url[] = $url_string;
                if ($one_full_url_record[2][$i] != "")
                {
                    $final_url[] = $parameters[$one_full_url_record[2][$i]];
                }
                else
                {
                }
                $i = $i + 1;
            }
            $final_url = implode("", $final_url);

            if ($anchor != "")
            {
                return $this->root_url() . $final_url . "#" . $anchor;
            }
            else
            {
                return $this->root_url() . $final_url;
            }
        }
        else
        {
            echo "[ERROR] Get URL \"" . $url_record[0] . "->" . $url_record[1] . "->" . $url_record[2] . "\" wrong in url_parser->get() <br />";
            //exit();
        }
    }


    /*
     * Get static link.
     */
    public function get_static($app_name, $filename)
    {
        return $this->root_url() . "/apps/" . $app_name . "/static/" . $filename;
    }


    /*
     * Get static  link, relate.
     */
    public function get_static_relate($app_name, $filename)
    {
        return "/apps/" . $app_name . "/static/" . $filename;
    }


    /*
     * Get static file.
     */
    public function get_static_file($app_name, $filename)
    {
        return ROOT_PATH . "/apps/" . $app_name . "/static/" . $filename;
    }


    /*
     * Get root url, http or https.
     */
    public function root_url()
    {
        if (empty($_SERVER["HTTPS"]))
        {
            return $root_url = "http://" . $_SERVER["HTTP_HOST"] . SITE_BASE;
        }
        else
        {
            return $root_url = "https://" . $_SERVER["HTTP_HOST"] . SITE_BASE;
        }
    }


    /*
     * Recursive match URI.
     */
    private function parse_uri($url_map, $target_string, $original_string)
    {
        foreach ($url_map as $one_map)
        {
            if (preg_match("%" . $one_map[0] . "%", $target_string, $matches) === 1)
            {
                if (is_array($one_map[3][0]) === TRUE)
                {
                    $new_string = substr($target_string, strlen($matches[0]));
                    // The return here is necessary.
                    return $this->parse_uri($one_map[3], $new_string, $original_string);
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
                            "url" => $this->root_url() . $original_string,
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
            "app_name" => MAIN_APP,
            "controller_type" => "SPECIAL",
            "special_flag" => "NOT_FOUND",
            "controller_name" => "",
            "action_name" => "",
            "method" => "",
            "target" => "",
            "parameters" => array(
                "get" => array(),
                "post" => $_POST,
                "url" => $this->root_url() . $original_string,
            ),
        );
    }


    /*
     * Unlimit levels.
     */
    public function full_url_map($init_url_map, $pattern, $url, $parameters, $full_url_map)
    {
        foreach ($init_url_map as $one_value)
        {
            if (is_array($one_value[3][0]) === TRUE)
            {
                /*
                 * Have sub level.
                 */
                $local_pattern = $pattern . substr($one_value[0], 1);
                $local_url = array($url[0] . $one_value[1][0]);
                $local_parameters = array("");

                $sub_url_map = $one_value[3];

                // That is it, NOT $full_url_map[] = $this->full_url_map(...)
                $full_url_map = array_merge($full_url_map, $this->full_url_map($sub_url_map, $local_pattern, $local_url, $local_parameters, array()));
            }
            else
            {
                /*
                 * Last level.
                 */
                $local_pattern = $pattern . substr($one_value[0], 1);
                $local_url = $one_value[1];
                $local_url[0] = $url[0] . $one_value[1][0];
                $local_parameters = $one_value[2];

                $full_url_map[] = array(
                    $local_pattern,
                    $local_url,
                    $local_parameters,
                    $one_value[3],
                    $one_value[4],
                );
            }
        }

        return $full_url_map;
    }


    public function get_full_url_map()
    {
        return $this->full_url_map($this->url_map, "^", array(""), array(""), array());
    }


    /*
     * Search urls record.
     */
    private function search_url_record($url_record)
    {
        foreach ($this->get_full_url_map() as $one_full_url_record)
        {
            if ($url_record === $one_full_url_record[4])
            {
                return $one_full_url_record;
            }
        }

        return FALSE;
    }
}
?>
