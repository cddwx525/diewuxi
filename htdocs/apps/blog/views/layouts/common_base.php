<?php
namespace blog\views\layouts;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\view;

abstract class common_base extends view
{
    protected $description = "";
    protected $keywords = "";
    protected $js = array();
    protected $css = array();
    protected $title = "";

    protected $position = array();
    protected $main = "";

    protected $text = "";


    /**
     *
     *
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->set_items();
        $this->set_text();
    }


    /**
     *
     *
     */
    abstract protected function set_items();


    /**
     *
     *
     */
    protected function get_head()
    {
        if (! empty($this->get_description()))
        {
            $head_list[] = $this->get_description();
        }

        if (! empty($this->get_keywords()))
        {
            $head_list[] = $this->get_keywords();
        }

        if (! empty($this->get_js()))
        {
            $head_list[] = $this->get_js();
        }

        if (! empty($this->get_css()))
        {
            $head_list[] = $this->get_css();
        }

        if (! empty($this->get_title()))
        {
            $head_list[] = $this->get_title();
        }

        $head = html::tag(
            "head",
            "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />" . "\n" .
            "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">" . "\n" .
            //"<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" />" . "\n" .
            implode("\n", $head_list),
            array()
        );

       return $head;
    }


    /**
     *
     *
     */
    private function get_description()
    {
        $description = "<meta name=\"description\" content=\"" . htmlspecialchars($this->description) . "\" />";

        return $description;
    }


    /**
     *
     *
     */
    private function get_keywords()
    {
        $keywords = "<meta name=\"keywords\" content=\"" . htmlspecialchars($this->keywords) . "\" />";

        return $keywords;
    }


    /**
     *
     *
     */
    private function get_js()
    {
        $js_list = array();
        $js_list = $this->js;

        if (! empty($js_list))
        {
            $js_link = array();
            foreach ($js_list as $one_js)
            {
                $js_link[] = $one_js;
            }
            $js = implode("\n", $js_link);

            return $js;
        }
        else
        {
            return "";
        }
    }


    /**
     *
     *
     */
    private function get_css()
    {
        $css_list = array();
        $css_list[] = url::get_static("css/main.css");

        $css_list = array_merge($css_list, $this->css);

        if (! empty($css_list))
        {
            $css_link = array();
            foreach ($css_list as $one_css)
            {
                $css_link[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $one_css . "\" />";
            }

            $css = implode("\n", $css_link);

            return $css;
        }
        else
        {
            return "";
        }
    }


    /**
     *
     *
     */
    private function get_title()
    {
        $title_list = array();
        $title_list[] = htmlspecialchars($this->title);
        $title_list[] = \swdf::$app->title;
        $title_list[] = \swdf::$app->config["site_name"];

        $title = "<title>" . implode(" - ", $title_list) . "</title>";

        return $title;
    }


    /**
     *
     *
     */
    protected function get_body()
    {
        $body = html::tag(
            "body",
            $this->get_header() . "\n" .
            $this->get_position() . "\n" .
            $this->get_menu() . "\n" .
            "<hr />" . "\n" .
            $this->get_main() . "\n" .
            "<hr />" . "\n" .
            $this->get_footer(),
            array()
        );

       return $body;
    }


    /**
     *
     *
     */
    private  function get_header()
    {
        $header = html::tag(
            "div",
            html::inline_tag(
                "h1",
                html::a(
                    \swdf::$app->config["site_name"],
                    url::get(\swdf::$app->main_app["special_actions"]["default"], array(), ""),
                    array()
                ),
                array()
            ) . "\n" .
            html::inline_tag("p", \swdf::$app->config["site_description"], array()),
            array()
        );

       return $header;
    }


    /*
     *
     *
     */
    private function get_position()
    {
        $position_list = array();

        $position_list[] = html::a(
            \swdf::$app->title,
            url::get(\swdf::$app->special_actions["default"], array(), ""),
            array()
        );

        $position_list = array_merge($position_list, $this->position);

        $position_link = array();
        foreach ($position_list as $one_position)
        {
            $position_link[] = html::inline_tag("li", $one_position, array("class" => "inline"));
        }

        $position_link = implode(
            "\n" .
            html::inline_tag("li", "/", array("class" => "inline")) .
            "\n",
            $position_link
        );

        $position = html::tag(
            "div",
            html::tag(
                "ul",
                $position_link,
                array("class" => "unstyle-list")
            ),
            array()
        );

        return $position;
    }


    /**
     *
     *
     */
    public function get_menu()
    {
        $menu_data = array(
            array(
                url::get(array(\swdf::$app->name, "guest/home.show", ""), array(), ""),
                "Home",
            ),
            array(
                url::get(array(\swdf::$app->name, "guest/article.list_all", ""), array(), ""),
                "Articles",
            ),
            array(
                url::get(array(\swdf::$app->name, "guest/category.list_all", ""), array(), ""),
                "Cateories",
            ),
            array(
                url::get(array(\swdf::$app->name, "guest/tag.list_all", ""), array(), ""),
                "Tags",
            ),
            array(
                url::get(array(\swdf::$app->name, "guest/about.show", ""), array(), ""),
                "About",
            ),
        );


        $menu_link_list = array();
        foreach ($menu_data as $one_menu)
        {
            $menu_link_list[] = html::inline_tag(
                "li",
                html::a($one_menu[1], $one_menu[0], array()),
                array("class" => "inline text-padding")
            );
        }
        $menu_link = implode("\n", $menu_link_list);

        $menu = html::tag(
            "div",
            html::inline_tag(
                "h2",
                \swdf::$app->title,
                array("class" => "inline-block")
            ) . "\n\n" .
            html::tag(
                "ul",
                $menu_link,
                array("class" => "unstyle-list inline-block")
            ),
            array()
        );

        return $menu;
    }


    /**
     *
     *
     */
    private function get_main()
    {
        $main = html::tag(
            "div",
            $this->main,
            array()
        );

        return $main;
    }


    /**
     *
     *
     */
    private function get_footer()
    {
        $footer = html::tag(
            "div",
            html::inline_tag(
                "p",
                \swdf::$app->config["site_name"] . " " . \swdf::$app->config["site_begin_year"] . "--" . date("Y"),
                array("class" => "float-right")
            ) . "\n" .
            html::tag(
                "div",
                "",
                array("class" => "clear-both")
            ),
            array()
        );

        return $footer;
    }



    /**
     *
     *
     */
    protected function get_text()
    {
        return $this->text;
    }

    /**
     *
     *
     */
    abstract protected function set_text();
}
?>
