<?php
namespace blog\views\admin\tag;

use blog\lib\url;
use blog\lib\views\admin_base;

class edit extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $tag = $result["tag"];
        $tags = $result["tags"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Edit tag";
        $position = " > Edit tag";

        if (empty($tags))
        {
            $tag_names = "<p>There is no tags now.</p>";
        }
        else
        {
            $tag_names = array();
            foreach ($tags as $one_tag)
            {
                $tag_names[] = "<a href=\"" . $url->get(array($app_space_name, "admin/tag.show", ""), array("id" => $one_tag["id"]), "") . "\">" . htmlspecialchars($one_tag["name"]) . "</a>";
            }
            $tag_names = implode(" ", $tag_names);
        }

        $tag_edit = "<div class=\"content_title border_frame\" >
<h3>Edit tag(* must be write)</h3>
</div>

<div id=\"edit\" class=\"border_frame\">
<p>Availiable tags:</p>
" . $tag_names . "

<form action=\"". $url->get(array($app_space_name, "admin/tag.update", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>
<p><input type=\"hidden\" name=\"id\" value=\"" . $tag["id"] . "\" /></p>

<p>* Name(vchar(64)):</p>
<p><input type=\"text\" name=\"name\" value=\"" . $tag["name"] . "\" class=\"input_text\" /></p>

<p>Slug(vchar(64)):</p>
<p><input type=\"text\" name=\"slug\" value=\"" . $tag["slug"] . "\" class=\"input_text\" /></p>

<p>Description(text):</p>
<p><textarea name=\"description\" class=\"textarea\">" . $tag["description"] . "</textarea></p>

<p><input type=\"submit\" name=\"update\" value=\"Update\" class=\"input_submit\" /></p>
</form >
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $tag_edit . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
