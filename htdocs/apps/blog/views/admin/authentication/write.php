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

        $content = "<div class=\"content_title border_frame\">
<h3>Login write</h3>
</div>

<div id=\"login_write\" class=\"border_frame\">
<form action=\"" . $url->get(array($app_space_name, "admin/authentication.login", ""), array(), "") . "\" method=\"post\">
<label>Username:</label>
<p><input type=\"text\" name=\"name\" value=\"\" class=\"input_text\" /></p>

<label>Password:</label>
<p><input type=\"password\" name=\"password\" value=\"\" class=\"input_text\" /></p>

<label>Remember me</label>
<p><input type=\"checkbox\" name=\"remember\" value=\"TRUE\" /></p>

<p><input type=\"submit\" name=\"\" value=\"Login\" class=\"input_submit\" /></p>
</form>
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
