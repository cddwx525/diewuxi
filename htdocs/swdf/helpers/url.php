<?php
namespace swdf\helpers;

class url
{

    /**
     *
     * Get dynamic urls.
     */
    public static function get($url_record, $parameters, $anchor)
    {
        $one_full_url_record = self::search_url_record($url_record);

        if ($one_full_url_record !== FALSE)
        {
            $final_url = array();
            $i = 0;
            foreach ($one_full_url_record[1] as $url_string)
            {
                $final_url[] = $url_string;
                if ($one_full_url_record[2][$i] !== "")
                {
                    $final_url[] = $parameters[$one_full_url_record[2][$i]];
                }
                else
                {
                }
                $i = $i + 1;
            }
            $final_url = implode("", $final_url);

            if ($anchor !== "")
            {
                return self::root_url() . $final_url . "#" . $anchor;
            }
            else
            {
                return self::root_url() . $final_url;
            }
        }
        else
        {
            print "[ERROR] Get URL \"" . $url_record[0] . "->" . $url_record[1] . "->" . $url_record[2] . "\" wrong in url_parser->get() <br />";
        }
    }


    /**
     *
     * Get static link.
     */
    public static function get_static($name)
    {
        return self::root_url() . "/" . APP_DIR . "/" . \swdf::$app->name . "/" . WEB_DIR . "/" . $name;
    }


    /**
     *
     * Get static  link, relate.
     */
    public static function get_static_relate($name)
    {
        return "/" . APP_DIR . "/" . \swdf::$app->name . "/" . WEB_DIR . "/" . $name;
    }


    /**
     *
     * Get file path.
     */
    public static function get_path($name)
    {
        return ROOT_PATH . "/" . APP_DIR . "/" . \swdf::$app->name . "/" . WEB_DIR . "/" . $name;
    }


    /**
     *
     * Get root url, http or https.
     */
    public static function root_url()
    {
        if (empty($_SERVER["HTTPS"]))
        {
            if (empty(\swdf::$app->config["site_base"]))
            {
                return $root_url = "http://" . $_SERVER["HTTP_HOST"];
            }
            else
            {
                return $root_url = "http://" . $_SERVER["HTTP_HOST"] . "/" . \swdf::$app->config["site_base"];
            }
        }
        else
        {
            if (empty(\swdf::$app->config["site_base"]))
            {
                return $root_url = "https://" . $_SERVER["HTTP_HOST"];
            }
            else
            {
                return $root_url = "https://" . $_SERVER["HTTP_HOST"] . "/" . \swdf::$app->config["site_base"];
            }
        }
    }


    /**
     *
     *
     */
    private static function full_url_map($init_url_map, $pattern, $url, $parameters, $full_url_map)
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

                // That is it, NOT $full_url_map[] = self::full_url_map(...)
                $full_url_map = array_merge($full_url_map, self::full_url_map($sub_url_map, $local_pattern, $local_url, $local_parameters, array()));
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


    /**
     *
     *
     */
    private static function get_full_url_map()
    {
        return self::full_url_map(\swdf::$app->url_map, "^", array(""), array(""), array());
    }


    /**
     *
     * Search urls record.
     */
    private static function search_url_record($url_record)
    {
        foreach (self::get_full_url_map() as $one_full_url_record)
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
