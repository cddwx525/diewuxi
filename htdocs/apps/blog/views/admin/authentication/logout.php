<?php
namespace blog\views\admin\authentication;

use blog\lib\url;
use blog\lib\views\login_base;

class logout extends login_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];

        $title = "Logout";

        $position = " > Logout";


        $message = "<p class=\"success\">Logout successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "guest/home.show", ""), array(), "") . "\">Home</a></p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Re login</a></p>";

        $content = "<div class=\"content_title border_frame\">
<h3>Logout</h3>
</div>

<div class=\"message border_frame\">
" . $message . "
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
