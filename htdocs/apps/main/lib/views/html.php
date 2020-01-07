<?php
namespace main\lib\views;

use main\lib\url;

class html
{
    /**
     *
     */
    public function text($result)
    {
        $text = $this->get_text($result);

        print $text;
    }

    /**
     *
     */
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


    /**
     *
     */
    public function get_head($result)
    {
        $meta_content_type = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
        $meta_xua = "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">";
        $meta_viewport = "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" />";

        $description = $this->get_description($result);
        $keywords = $this->get_keywords($result);
        $js = $this->get_js($result);
        $css = $this->get_css($result);
        $title = $this->get_title($result);

        $head = array();
        $head[] = $meta_content_type;
        $head[] = $meta_xua;
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


    /**
     *
     */
    public function get_body($result)
    {
        $body = array();
        $body[] = $this->get_header($result);
        $body[] = $this->get_position($result);
        $body[] = $this->get_menu($result);
        $body[] = $this->get_main($result);
        $body[] = $this->get_footer($result);
        $body[] = $this->get_end_js($result);

        $body = implode("\n", $body);
        $body ="<div class=\"container-fluid\">\n" . $body . "\n</div>";

        return $body;
    }


    /**
     * Static functions
     *
     */
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

        $css_list = array();
        $css_list[] = $url->get_static($result["meta_data"]["main_app"]["app_space_name"], "bootstrap/css/bootstrap.min.css");
        if ($result["meta_data"]["settings"]["app_space_name"] === "main")
        {
            $css_list[] = $url->get_static($result["meta_data"]["settings"]["app_space_name"], "css/main.css");
        }
        else
        {
            $css_list[] = $url->get_static($result["meta_data"]["main_app"]["app_space_name"], "css/main.css");
            $css_list[] = $url->get_static($result["meta_data"]["settings"]["app_space_name"], "css/main.css");
        }

        if (isset($items["css"]))
        {
            $items["css"] = array_merge($css_list, $items["css"]);
        }
        else
        {
            $items["css"] = $css_list;
        }

        $css = array();
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


    public static function get_title_html($result, $items)
    {
        if ($result["meta_data"]["settings"]["app_space_name"] === "main")
        {
            $items["title"] = $items["title"] . " - " . $result["meta_data"]["main_app"]["site_name"];
        }
        else
        {
            $items["title"] = $items["title"] . " - " . $result["meta_data"]["settings"]["app_default_name"] . " - " . $result["meta_data"]["main_app"]["site_name"];
        }

        $title = "<title>" . $items["title"] . "</title>";

        return $title;
    }


    public static function get_header_html($result, $items)
    {
        $url = new url();

        $header = "<div class=\"bg-info\">
<h1><a href=\"" . $url->get($result["meta_data"]["main_app"]["special_actions"]["DEFAULT"], array(), "") . "\">" . $result["meta_data"]["main_app"]["site_name"] . "</a></h1>
<p>" . $result["meta_data"]["main_app"]["site_description"] . "</p>
</div>";

        return $header;
    }


    public static function get_position_html($result, $items)
    {
        $url = new url();

        $position_link_list = array();
        if ($result["meta_data"]["settings"]["app_space_name"] === "main")
        {
            $position_link_list[] = "<a href=\"" . $url->get($result["meta_data"]["main_app"]["special_actions"]["DEFAULT"], array(), "") . "\">Home</a>";
        }
        else
        {
            $position_link_list[] = "<a href=\"" . $url->get($result["meta_data"]["main_app"]["special_actions"]["DEFAULT"], array(), "") . "\">Home</a>";
            $position_link_list[] = "<a href=\"" . $url->get($result["meta_data"]["settings"]["special_actions"]["DEFAULT"], array(), "") . "\">" . $result["meta_data"]["settings"]["app_default_name"] . "</a>";
        }

        $position_link = implode(" > ", $position_link_list);
        $position_link = $position_link . $items["position"];

        $position = "<div>
<span>Current position: </span>" . $position_link . "
</div>";

        return $position;
    }


    public static function get_menu_html($result, $items)
    {
        $url = new url();

        $menu = array();
        
        $menu_list_link = array();
        foreach ($items["menu_list"] as $one_menu)
        {
            $menu_list_link[] = "<li><a href=\"" . $one_menu[0] . "\">" . $one_menu[1] . "</a></li>";
        }
        $menu_list_link = implode("\n", $menu_list_link);

        $menu[] = "<div class=\"bg-info\">
<h2>" . $result["meta_data"]["settings"]["app_default_name"] . "</h2>";

        if (isset($items["user_operation"]))
        {
            $menu[] = $items["user_operation"];
        }
        else
        {
        }

        $menu[] = "</div>";

        $menu[] = "<div role=\"navigation\" class=\"navbar navbar-inverse\">
<div class=\"container-fluid\">

<div class=\"navbar-header\">
<button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\" aria-expanded=\"false\">
<span class=\"sr-only\">Toggle navigation</span>
<span class=\"icon-bar\"></span>
<span class=\"icon-bar\"></span>
<span class=\"icon-bar\"></span>
</button>
</div>

<div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
<ul class=\"nav navbar-nav\">
" . $menu_list_link . "
</ul>
</div>

</div>
</div>";

        return implode("\n", $menu);
    }


    public static function get_main_html($result, $items)
    {
        $main = $items["main"]; 

        return $main;
    }


    public static function get_footer_html($result, $items)
    {
        $url = new url();

        $footer = "<div class=\"row\">
<div class=\"col-md-12\">
<div class=\"block_box bg-info\">
<p class=\"text-right\">" . $result["meta_data"]["main_app"]["site_name"] . " " . $result["meta_data"]["main_app"]["site_begin_year"] . "--" . date("Y") . "</p>
</div>
</div>
</div>";

        return $footer;
    }


    public static function get_end_js_html($result, $items)
    {
        $url = new url();

        return "<script src=\"" . $url->get_static($result["meta_data"]["main_app"]["app_space_name"], "jquery/jquery-1.12.4.min.js") . "\"></script>
<script src=\"" . $url->get_static($result["meta_data"]["main_app"]["app_space_name"], "bootstrap/js/bootstrap.min.js") . "\"></script>";
    }
}
?>
