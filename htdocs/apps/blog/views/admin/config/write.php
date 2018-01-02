<?php
namespace blog\views\admin\config;

use blog\lib\url;
use blog\lib\views\simple;

class write extends simple
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Write config";

        $position = " > Write config";


        $content = "<div id=\"content_title\" class=\"border_frame\">
<h3>Writet config</h3>
</div>

<div id=\"config_write\" class=\"border_frame\">
<p>Write option(* must be write)</p>

<form action=\"". $url->get(array($app_space_name, "admin/config.save", ""), array(), "") . "\" method=\"post\">
<p>* Blog name(longtext):</p>
<p><input type=\"text\" name=\"blog_name\" value=\"\" class=\"input_text\" /></p>

<p>Blog description(longtext):</p>
<p><input type=\"text\" name=\"blog_description\" value=\"\" class=\"input_text\" /></p>

<p>* Admin user name(varchar(32)):</p>
<p><input type=\"text\" name=\"name\" value=\"\" class=\"input_text\" /></p>

<p>* Admin user password(varchar(256)):</p>
<p><input type=\"password\" name=\"password\" value=\"\" class=\"input_text\" /></p>

<p><input type=\"submit\" name=\"save\" value=\"Save\" class=\"input_submit\" /></p>
</form >
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
