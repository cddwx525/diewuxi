<?php
namespace blog\views\admin\category;

use blog\lib\url;
use blog\lib\views\admin_base;

class write extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $categories = $result["categories"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Write category";
        $position = " > Write category";

        if (empty($categories))
        {
            $category_names = "<p>There is no categories now.</p>";
        }
        else
        {
            $category_names = "<ul>
" . $this->category_output($result, $categories, array(), $url, "") . "
</ul>";
        }

        $category_write = "<div class=\"content_title border_frame\" >
<h3>Write category(* must be write)</h3>
</div>

<div id=\"write\" class=\"border_frame\">
<p>Availiable categories:</p>
" . $category_names . "

<form action=\"". $url->get(array($app_space_name, "admin/category.add", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>

<p>* Name(vchar(64)):</p>
<p><input type=\"text\" name=\"name\" value=\"\" class=\"input_text\" /></p>

<p>* Slug(vchar(64)):</p>
<p><input type=\"text\" name=\"slug\" value=\"\" class=\"input_text\" /></p>

<p>* Parent(vchar(64))(chose one from above or \"NULL\"):</p>
<p><input type=\"text\" name=\"parent\" value=\"\" class=\"input_text\" /></p>

<p>Description(text):</p>
<p><textarea name=\"description\" class=\"textarea\"></textarea></p>

<p><input type=\"submit\" name=\"add\" value=\"Add\" class=\"input_submit\" /></p>
</form >

</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $category_write . "\n" . "</div>";

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
