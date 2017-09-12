<?php
include CONFIG_PATH . "/urls.php";

class url_parser
{
    protected $url_map = array();

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


    function get($url_record, $parameter, $anchor)
    {
        //return $this->full_url_map();
        $one_full_url_record = $this->search_url_record($url_record);
        //print_r($one_full_url_record);
        //exit();
        if ($one_full_url_record != FALSE)
        {
            $final_url = array();
            $i = 0;
            foreach ($one_full_url_record[1] as $url_string)
            {
                $final_url[] = $url_string;
                if ($one_full_url_record[2][$i] != "")
                {
                    $final_url[] = $parameter[$one_full_url_record[2][$i]];
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
            return FALSE;
        }
    }


    public function get_static($filename)
    {
        return $this->root_url() . "/apps/" . APP_NAME . "/static/" . $filename;
    }


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


    private function parse_uri($url_map, $target_string, $original_string)
    {
        foreach ($url_map as $one_map)
        {
            if (preg_match("%" . $one_map[0] . "%", $target_string, $matches) === 1)
            {
                if (is_array($one_map[3][0]) === TRUE)
                {
                    $new_string = substr($target_string, strlen($matches[0]));
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
                        "controller_name" => $one_map[3][2],
                        "method" => $one_map[3][3],
                        "target" => $one_map[3][4],
                        "url_parameters" => $match_variable,
                        "url" => $this->root_url() . $original_string,
                    );
                }
            }
            else
            {
            }
        }

        return array(
            "app_name" => MAIN_APP,
            "controller_type" => "SPECIAL",
            "controller_name" => "NOT_FOUND",
            "method" => "",
            "target" => "",
            "url_parameters" => array(),
            "url" => $this->root_url() . $original_string,
        );
    }


    private function full_url_map()
    {
        $full_url_map = array();
        foreach ($this->url_map as $key => $value)
        {
            if (is_array($value[3][0]) === FALSE)
            {
                $full_url_map[] = $value;
            }
            else
            {
                foreach ($value[3] as $sub_url_map)
                {
                    $full_url_map[] = array(
                        $value[0] . $sub_url_map[0],
                        array_merge($value[1], $sub_url_map[1]),
                        array_merge($value[2], $sub_url_map[2]),
                        $sub_url_map[3],
                        $sub_url_map[4],
                    );
                }
            }
        }

        return $full_url_map;
    }


    private function search_url_record($url_record)
    {
        foreach ($this->full_url_map() as $one_full_url_record)
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
