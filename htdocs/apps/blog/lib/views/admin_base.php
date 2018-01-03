<?php
namespace blog\lib\views;

use blog\lib\url;
use blog\lib\views\base;

abstract class admin_base extends base
{
    public function get_css($result)
    {
        $url = new url();

        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        $css = array();
        $css[] = $url->get_static($result["meta_data"]["settings"]["app_space_name"], "css/admin.css");

        if (isset($items["css"]))
        {
            $items["css"] = array_merge($css, $items["css"]);
        }
        else
        {
            $items["css"] = $css;
        }

        return $html_view::get_css_html($result, $items);
    }


    public function get_title($result)
    {
        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        $items["title"] = $items["title"] . " - Administration - ";

        return $html_view::get_title_html($result, $items);
    }


    public function get_position($result)
    {
        $url = new url();

        $html_view = MAIN_APP . "\\lib\\views\\html";
        $items = $this->get_items($result);

        $position = " > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/home.show", ""), array(), "") . "\">Administration</a>";

        $items["position"] = $position . $items["position"];

        return $html_view::get_position_html($result, $items);
    }


    public function get_menu($result)
    {
        $url = new url();

        $html_view = MAIN_APP . "\\lib\\views\\html";

        $items = $this->get_items($result);
        
        $items["menu_list"] = array(
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/home.show", ""), array(), ""),
                "Home",
            ),
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/article.list_all", ""), array(), ""),
                "Articles",
            ),
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/category.list_all", ""), array(), ""),
                "Cateories",
            ),
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/tag.list_all", ""), array(), ""),
                "Tags",
            ),
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/comment.list_all", ""), array(), ""),
                "Comments",
            ),
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/media.list_all", ""), array(), ""),
                "Medias",
            ),
            array(
                $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/settings.show", ""), array(), ""),
                "Settings",
            ),
        );

        $items["user_operation"] = "<div id=\"user_operation\">
<ul>
<li>User: [" . $result["meta_data"]["session"]["user"]["name"] . "]</li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/authentication.logout", ""), array(), "") . "\">Logout</a></li>
</ul>
</div>";

        return $html_view::get_menu_html($result, $items);
    }
}
?>
