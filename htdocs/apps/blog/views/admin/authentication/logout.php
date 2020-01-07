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


        $message = "<p class=\"text-success\">Logout successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "guest/home.show", ""), array(), "") . "\">Home</a></p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Re login</a></p>";

        $content = "<h3 class=\"bg-primary\">Logout</h3>
" . $message;

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }

    public function get_string($result)
    {
        return "[text]";
    }
}
?>
