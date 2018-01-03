<?php
namespace blog\views\admin;

use blog\lib\url;
use blog\lib\views\admin_base;

class settings extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $state = $result["state"];
        $parameters = $result["parameters"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Setting";

        $position = " > <a href=\"" . $url->get(array($app_space_name, "admin/settings.show", ""), array(), "") . "\">Setting</a>";

        $content = "<div class=\"content_title border_frame\">
<h3>Setting</h3>
</div>

<div id=\"content\" class=\"border_frame\">
<ul>
<li><a href=\"" . $url->get(array($app_space_name, "admin/account.edit", ""), array(), "") . "\">Account setting</a></li>
<li><a href=\"" . $url->get(array($app_space_name, "admin/option.edit", ""), array(), "") . "\">Site options</a></li>
</ul>
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
