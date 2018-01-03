<?php
namespace blog\lib\views;

use blog\lib\url;
use blog\models\option;

abstract class base
{
    abstract public function get_items($result);

    public function layout($result)
    {
        $head = $this->get_head($result);
        $body = $this->get_body($result);

        print "<!DOCTYPE html>
<html>
<head>
" . $head . "
</head>
<body>
" . $body . "
</body>
</html>";
    }


    public function get_head($result)
    {
        $meta_http_equiv = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
        $meta_viewport = "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />";

        $description = $this->get_description($result);
        $keywords = $this->get_keywords($result);
        $js = $this->get_js($result);
        $css = $this->get_css($result);
        $title = $this->get_title($result);

        $head = array();
        $head[] = $meta_http_equiv;
        $head[] = $meta_viewport;
        if (! empty($description))
        {
            $head[] = $description;
        }
        if (! empty($keywords))
        {
            $head[] = $keywords;
        }
        if (! empty($js))
        {
            $head[] = $js;
        }
        if (! empty($css))
        {
            $head[] = $css;
        }
        $head[] = $this->get_title($result);

        $head = implode("\n", $head);

        return $head;
    }


    public function get_description($result)
    {
        $items = $this->get_items($result);

        if (isset($items["description"]))
        {
            $description = "<meta name=\"description\" content=\"" . htmlspecialchars($items["description"]) . "\" />";
        }
        else
        {
            $description = "";
        }

        return $description;
    }


    public function get_keywords($result)
    {
        $items = $this->get_items($result);

        if (isset($items["keywords"]))
        {
            $keywords = "<meta name=\"keywords\" content=\"" . htmlspecialchars($items["keywords"]) . "\" />";
        }
        else
        {
            $keywords = "";
        }

        return $keywords;
    }


    public function get_js($result)
    {
        $items = $this->get_items($result);

        $js = array();

        if (isset($items["js"]))
        {
            foreach ($items["js"] as $one_js)
            {
                $js[] = $one_js;
            }

        }
        else
        {
        }

        $js = implode("\n", $js);

        return $js;
    }

    abstract public function get_css($result);


    abstract public function get_title($result);


    public function get_body($result)
    {
        $body = array();
        $body[] = $this->get_header($result);
        $body[] = $this->get_position($result);
        $body[] = $this->get_menu($result);
        $body[] = $this->get_main($result);
        $body[] = $this->get_footer($result);

        $body = implode("\n\n", $body);

        return $body;
    }


    public function get_header($result)
    {
        $url = new url();

        $header = "<div id=\"header\" class=\"border_frame\">
<div id=\"site_name\">
<h1><a href=\"" . $url->get($result["meta_data"]["main_app"]["special_actions"]["DEFAULT"], array(), "") . "\">" . $result["meta_data"]["main_app"]["site_name"] . "</a></h1>
</div>

<div id=\"site_description\">
<p>" . $result["meta_data"]["main_app"]["site_description"] . "</p>
</div>
</div>";

        return $header;
    }


    abstract public function get_position($result);


    /*
     * Menu part.
     */
    abstract public function get_menu($result);


    abstract public function get_main($result);


    /*
     * Foot part.
     */
    public function get_footer($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $footer = "<div id=\"footer\" class=\"border_frame\">
<p>" . $result["meta_data"]["main_app"]["site_name"] . " " . $result["meta_data"]["main_app"]["site_begin_year"] . "--" . date("Y") . "</p>
</div>";

        return $footer;
    }
}
?>
