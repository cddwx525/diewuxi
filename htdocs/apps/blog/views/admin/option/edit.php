<?php
namespace blog\views\admin\option;

use blog\lib\url;
use blog\lib\views\admin_base;

class edit extends admin_base
{
    public function get_items($result)
    {
        $url = new url();
        $options = $result["meta_data"]["options"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Edit option";

        $position = " > <a href=\"" . $url->get(array($app_space_name, "admin/settings.show", ""), array(), "") . "\">Setting</a> > Edit option";

        $content = "<div class=\"content_title border_frame\">
<h3>Edit option</h3>
</div>

<div id=\"edit\" class=\"border_frame\">
<h4>Edit option(* must be write)</h4>

<form action=\"". $url->get(array($app_space_name, "admin/option.update", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $result["form_stamp"] . "\" /></p>

<p>* Blog name(longtext):</p>
<p><input type=\"text\" name=\"blog_name\" value=\"" . $options["blog_name"] . "\" class=\"input_text\" /></p>

<p>Blog description(longtext):</p>
<p><textarea name=\"blog_description\" class=\"textarea\">" . $options["blog_description"] . "</textarea></p>

<p>* Home page(longtext):</p>
<p><input type=\"text\" name=\"home_page\" value=\"" . $options["home_page"] . "\" class=\"input_text\" /></p>

<p>* About page(longtext):</p>
<p><input type=\"text\" name=\"about_page\" value=\"" . $options["about_page"] . "\" class=\"input_text\" /></p>

<p><input type=\"submit\" name=\"update\" value=\"Update\" class=\"input_submit\" /></p>
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
