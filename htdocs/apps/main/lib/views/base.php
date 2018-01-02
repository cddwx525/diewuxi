<?php
namespace main\lib\views;

use main\lib\url;

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

    public function get_css($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $css = array();
        $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $url->get_static($result["meta_data"]["settings"]["app_space_name"], "css/main.css") . "\">";

        if (isset($items["css"]))
        {
            foreach ($items["css"] as $one_css)
            {
                $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $one_css . "\">";
            }
        }
        else
        {
        }

        $css = implode("\n", $css);

        return $css;
    }


    public function get_title($result)
    {
        $items = $this->get_items($result);

        $title = "<title>" . $items["title"] . " - " . $result["meta_data"]["settings"]["app_default_name"] . " - " . $result["meta_data"]["main_app"]["site_name"] . "</title>";

        return $title;
    }


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


    /*
     * Position part.
     */
    public function get_position($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $position_link_list = array();
        $position_link_list[] = "<a href=\"" . $url->get($result["meta_data"]["main_app"]["special_actions"]["DEFAULT"], array(), "") . "\">Home</a>";
        $position_link_list[] = "<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "home.show", ""), array(), "") . "\">" . $result["meta_data"]["settings"]["app_default_name"] . "</a>";

        $position_link = implode(" > ", $position_link_list);
        $position_link = $position_link . $items["position"];

        $position = "<div id=\"position\" class=\"border_frame\">
<span>Current position: </span>" . $position_link . "
</div>";

        return $position;
    }


    /*
     * Menu part.
     */
    public function get_menu($result)
    {
        $url = new url();

        $menu = "<div id=\"section\" class=\"border_frame\">

<div id=\"section_head\">
<h2>" . $result["meta_data"]["settings"]["app_default_name"] . "</h2>
</div>

<div id=\"menu\">

<div id=\"menu_list\">
<ul>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "home.show", ""), array(), "") . "\">Home</a></li>
<li><a href=\"" . $url->get(array("blog", "guest/home.show", ""), array(), "") . "\">[Blog]</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "one_page.show", ""), array(), "") . "\">One_age</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "about.show", ""), array(), "") . "\">About</a></li>
</ul>
</div>
</div>
</div>";

        return $menu;
    }


    /*
     * Main part.
     */
    public function get_main($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        return $items["main"];
    }


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
