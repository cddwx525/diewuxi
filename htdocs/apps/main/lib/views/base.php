<?php
namespace main\lib\views;

use main\lib\url;
use main\lib\views\html;

abstract class base extends html
{
    abstract public function get_items($result);


    public function get_description($result)
    {
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_description_html($result, $items);
    }


    public function get_keywords($result)
    {
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_keywords_html($result, $items);
    }


    public function get_js($result)
    {
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_js_html($result, $items);
    }


    public function get_css($result)
    {
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_css_html($result, $items);
    }


    public function get_title($result)
    {
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_title_html($result, $items);
    }



    public function get_header($result)
    {
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_header_html($result, $items);
    }


    public function get_position($result)
    {
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_position_html($result, $items);
    }


    public function get_menu($result)
    {
        $url = new url();

        $html_view = MAIN_APP . "\\lib\\views\\html";

        $items = $this->get_items($result);
        
        $items["menu_list"] = array(
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "home.show", ""), array(), ""),
                "Home",
            ),
            array(
                $url->get(array("blog", "guest/home.show", ""), array(), ""),
                "[Blog]",
            ),
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "one_page.show", ""), array(), ""),
                "One_age",
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
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_main_html($result, $items);
    }


    public function get_footer($result)
    {
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        return $html_view::get_footer_html($result, $items);
    }
}
?>
