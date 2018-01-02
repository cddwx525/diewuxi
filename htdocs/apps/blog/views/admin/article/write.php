<?php
namespace blog\views\admin\article;

use blog\lib\url;
use blog\lib\views\admin_base;

class write extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $categories = $result["categories"];
        $tags = $result["tags"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Write article";
        $position = " > Write article</a>";


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

        if (empty($tags))
        {
            $tag_names = "<span>There is no tags now.</span>";
        }
        else
        {
            $tag_names = array();
            foreach ($tags as $tag)
            {
                $tag_names[] = "<a href=\"" . $url->get(array($app_space_name, "admin/tag.show", ""), array("id" => $tag["id"]), "") . "\">" . htmlspecialchars($tag["name"]) . "</a>";
            }
            $tag_names = implode(", ", $tag_names);
        }

        $article_write = "<div class=\"content_title border_frame\" >
<h3>Write article(* must be write)</h3>
</div>

<div id=\"write\" class=\"border_frame\">
<form action=\"". $url->get(array($app_space_name, "admin/article.add", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>

<p>* Title(vchar(128)):</p>
<p><input type=\"text\" name=\"title\" value=\"\" class=\"input_text\" /></p>

<p>Slug(vchar(128)):</p>
<p><input type=\"text\" name=\"slug\" value=\"\" class=\"input_text\" /></p>

<p>* Date(datetime):</p>
<p><input type=\"text\" name=\"date\" value=\"" . date("Y-m-d H:i:s") . "\" class=\"input_text\" /></p>

<p>* Content(longtext):</p>
<p><textarea name=\"content\" class=\"textarea\"></textarea></p>

<p>* Category:</p>
<p>Availiable categories(only has one):</p>
" . $category_names . "
<p><input type=\"text\" name=\"category_name\" value=\"\" class=\"input_text\" /></p>

<p>Tag(seperated by comma and a space):</p>
<p>Availiable tags(seperated multitags by comma and a space):</p>
<p>" . $tag_names . "</p>
<p><input type=\"text\" name=\"tag_name\" value=\"\" class=\"input_text\" /></p>

<p>* Keywords(text):</p>
<p><input type=\"text\" name=\"keywords\" value=\"\" class=\"input_text\" /></p>

<p>* Description(text):</p>
<p><textarea name=\"description\" class=\"textarea\"></textarea></p>

<p><input type=\"submit\" name=\"add\" value=\"Add\" class=\"input_submit\" /></p>
</form >

</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $article_write . "\n" . "</div>";

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
