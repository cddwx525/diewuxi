<?php
namespace main\lib\views;

use main\lib\url;
use main\lib\views\html;

abstract class base extends html
{
    abstract public function get_items($result);

    public function get_string($result)
    {
        return "[Undefine, default text.]";
    }


    public function get_text($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_string($result);

        return $items;
    }


    public function get_description($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_description_html($result, $items);
    }


    public function get_keywords($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_keywords_html($result, $items);
    }


    public function get_js($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_js_html($result, $items);
    }


    public function get_css($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_css_html($result, $items);
    }


    public function get_title($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_title_html($result, $items);
    }



    public function get_header($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_header_html($result, $items);
    }


    public function get_position($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_position_html($result, $items);
    }


    public function get_menu($result)
    {
        $url = new url();

        $html_view = "main\\lib\\views\\html";

        $items = $this->get_items($result);
        
        $items["menu_list"] = array(
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "home.show", ""), array(), ""),
                "Home",
            ),
            array(
                "#",
                "[Some sub app link]",
            ),
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "one_page.show", ""), array(), ""),
                "One age",
            ),
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "about.show", ""), array(), ""),
                "About",
            ),
        );

        return $html_view::get_menu_html($result, $items);
    }


    public function get_main($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_main_html($result, $items);
    }


    public function get_footer($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_footer_html($result, $items);
    }

    public function get_end_js($result)
    {
        $html_view = "main\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_end_js_html($result, $items);
    }
}
?>
