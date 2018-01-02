<?php
namespace blog\lib\views;

use blog\lib\url;
use blog\lib\views\base;

abstract class admin_base extends base
{
    public function get_css($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $css = array();
        $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $url->get_static($result["meta_data"]["main_app"]["app_space_name"], "css/main.css") . "\">";
        $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $url->get_static($result["meta_data"]["settings"]["app_space_name"], "css/main.css") . "\">";
        $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $url->get_static($result["meta_data"]["settings"]["app_space_name"], "css/admin.css") . "\">";

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

        $title = "<title>" . $items["title"] . " - Administration - " . $result["meta_data"]["options"]["blog_name"] . " - " . $result["meta_data"]["main_app"]["app_name"] . "</title>";

        return $title;
    }


    public function get_position($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $position_link_list = array();
        $position_link_list[] = "<a href=\"" . $url->get(array($result["meta_data"]["main_app"]["app_space_name"], "home.show", ""), array(), "") . "\">Home</a>";
        $position_link_list[] = "<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/home.show", ""), array(), "") . "\">" . $result["meta_data"]["options"]["blog_name"] . "</a>";
        $position_link_list[] = "<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/home.show", ""), array(), "") . "\">Administration</a>";

        $position_link = implode(" > ", $position_link_list);
        $position_link = $position_link . $items["position"];

        $positon = "<div id=\"position\" class=\"border_frame\">
<span>Current position: </span>" . $position_link . "
</div>";

        return $positon;
    }


    public function get_menu($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $menu = "<div id=\"section\" class=\"border_frame\">

<div id=\"section_head\">
<h2>" . $result["meta_data"]["options"]["blog_name"] . "</h2>
</div>

<div id=\"menu\">

<div id=\"user_operation\">
<ul>
<li>User: [" . $result["meta_data"]["session"]["user"]["name"] . "]</li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/authentication.logout", ""), array(), "") . "\">Logout</a></li>
</ul>
</div>

<div id=\"menu_list\">
<ul>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/home.show", ""), array(), "") . "\">Home</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/article.list_all", ""), array(), "") . "\">Articles</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/category.list_all", ""), array(), "") . "\">Cateories</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/tag.list_all", ""), array(), "") . "\">Tags</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/comment.list_all", ""), array(), "") . "\">Comments</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/media.list_all", ""), array(), "") . "\">Medias</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "admin/settings.show", ""), array(), "") . "\">Settings</a></li>
</ul>
</div>
</div>
</div>";

        return $menu;
    }


    public function get_main($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        return $items["main"];
    }
}
?>
