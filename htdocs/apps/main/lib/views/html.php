<?php
namespace main\lib\views;

use main\lib\url;

class html
{
    /***************************************************************************
     *
     **************************************************************************/
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

    /***************************************************************************
     *
     **************************************************************************/
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
        //$head[] = $meta_viewport;
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


    /***************************************************************************
     *
     **************************************************************************/
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




    public static function get_description_html($result, $items)
    {
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


    public static function get_keywords_html($result, $items)
    {
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


    public static function get_js_html($result, $items)
    {
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


    public static function get_css_html($result, $items)
    {
        $url = new url();

        $css = array();
        $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $url->get_static($result["meta_data"]["main_app"]["app_space_name"], "css/main.css") . "\">";
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

        $css = implode("\n", array_unique($css));

        return $css;
    }


    public static function get_title_html($result, $items)
    {
        $title = "<title>" . $items["title"] . " - " . $result["meta_data"]["settings"]["app_default_name"] . " - " . $result["meta_data"]["main_app"]["site_name"] . "</title>";

        return $title;
    }



    public static function get_header_html($result, $items)
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
    public static function get_position_html($result, $items)
    {
        $url = new url();

        $position_link_list = array();
        $position_link_list[] = "<a href=\"" . $url->get($result["meta_data"]["main_app"]["special_actions"]["DEFAULT"], array(), "") . "\">Home</a>";
        $position_link_list[] = "<a href=\"" . $url->get($result["meta_data"]["settings"]["special_actions"]["DEFAULT"], array(), "") . "\">" . $result["meta_data"]["settings"]["app_default_name"] . "</a>";

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
    public static function get_menu_html($result, $items)
    {
        $url = new url();
        
        $menu_list_link = array();
        foreach ($items["menu_list"] as $one_menu)
        {
            $menu_list_link[] = "<li><a href=\"" . $one_menu[0] . "\">" . $one_menu[1] . "</a></li>";
        }
        $menu_list_link = implode("\n", $menu_list_link);

        if (isset($items["user_operation"]))
        {
            $user_operation = $items["user_operation"];
        }
        else
        {
            $user_operation = "";
        }

        $menu = "<div id=\"section\" class=\"border_frame\">

<div id=\"section_head\">
<h2>" . $result["meta_data"]["settings"]["app_default_name"] . "</h2>
</div>

" . $user_operation . "

<div id=\"menu\">

<div id=\"menu_list\">
<ul>
" . $menu_list_link . "
</ul>
</div>
</div>
</div>";

        return $menu;
    }


    /*
     * Main part.
     */
    public static function get_main_html($result, $items)
    {
        $main = $items["main"]; 

        return $main;
    }


    /*
     * Foot part.
     */
    public static function get_footer_html($result, $items)
    {
        $url = new url();

        $footer = "<div id=\"footer\" class=\"border_frame\">
<p>" . $result["meta_data"]["main_app"]["site_name"] . " " . $result["meta_data"]["main_app"]["site_begin_year"] . "--" . date("Y") . "</p>
</div>";

        return $footer;
    }
}
?>
