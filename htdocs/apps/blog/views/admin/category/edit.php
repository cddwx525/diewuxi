<?php
namespace blog\views\admin\category;

use blog\lib\url;
use blog\lib\views\admin_base;

class edit extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $category = $result["category"];
        $categories = $result["categories"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Edit category";
        $position = " > Edit category";

        $category_names = "<ul>
" . $this->category_output($result, $categories, array(), $url, "") . "
</ul>";

        $category_edit = "<div class=\"content_title border_frame\" >
<h3>Edit category(* must be write)</h3>
</div>

<div id=\"edit\" class=\"border_frame\">

<form action=\"". $url->get(array($app_space_name, "admin/category.update", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>
<p><input type=\"hidden\" name=\"id\" value=\"" . $category["id"] . "\" /></p>

<p>* Name(vchar(64)):</p>
<p><input type=\"text\" name=\"name\" value=\"" . $category["name"] . "\" class=\"input_text\" /></p>

<p>Slug(vchar(64)):</p>
<p><input type=\"text\" name=\"slug\" value=\"" . $category["slug"] . "\" class=\"input_text\" /></p>

<p>Parent(vchar(64)):</p>
<p>Availiable categories:</p>
" . $category_names . "
<p><input type=\"text\" name=\"parent\" value=\"" . $category["parent"] . "\" class=\"input_text\" /></p>

<p>* Description(text):</p>
<p><textarea name=\"description\" class=\"textarea\">" . $category["description"] . "</textarea></p>

<p><input type=\"submit\" name=\"update\" value=\"Update\" class=\"input_submit\" /></p>

</form >
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $category_edit . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }

    private function category_output($result, $categories, $list, $url, $indent)
    {
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];

        foreach ($categories as $category)
        {
            if (isset($category["son"]))
            {
                $list[] = $indent . "<li><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $category["id"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a></li>
" . $indent . "<ul>
" . $this->category_output($result, $category["son"], array(), $url, $indent . "") . "
" . $indent . "</ul>";
            }
            else
            {
                $list[] = $indent . "<li><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $category["id"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a></li>";
            }
        }
        return implode("\n", $list);
    }
}
?>
