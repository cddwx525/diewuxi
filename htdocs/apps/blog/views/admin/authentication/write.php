<?php
namespace blog\views\admin\authentication;

use blog\lib\url;
use blog\lib\views\login_base;

class write extends login_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];

        $title = "Login write";

        $position = " > Login write";

        $content = "<h3 class=\"bg-primary\">Login write</h3>

<form action=\"" . $url->get(array($app_space_name, "admin/authentication.login", ""), array(), "") . "\" method=\"post\">
<label>Username:</label>
<p><input type=\"text\" name=\"name\" value=\"\" class=\"input_text\" /></p>

<label>Password:</label>
<p><input type=\"password\" name=\"password\" value=\"\" class=\"input_text\" /></p>

<label>Remember me</label>
<p><input type=\"checkbox\" name=\"remember\" value=\"TRUE\" /></p>

<p><input type=\"submit\" name=\"\" value=\"Login\" class=\"input_submit\" /></p>
</form>";

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
