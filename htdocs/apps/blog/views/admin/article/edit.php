<?php
namespace blog\views\admin\article;

use blog\lib\url;
use blog\lib\views\admin_base;

class edit extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $article = $result["article"];
        $categories = $result["categories"];
        $tags = $result["tags"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Edit article";
        $position = " > Edit article";

        $category_names = "<ul>
" . $this->category_output($result, $categories, array(), $url, "", "") . "
</ul>";

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

            $article_tag_names = array();
            foreach ($article["tag"] as $tag)
            {
                $article_tag_names[] = $tag["name"];
            }
            $article_tag_names = implode(", ", $article_tag_names);


        $content = "<h3 class=\"bg-primary\">Edit article</h3>

<p>Edit article(* must be write)</p>

<form action=\"". $url->get(array($app_space_name, "admin/article.update", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>
<p><input type=\"hidden\" name=\"id\" value=\"" . $article["id"] . "\" /></p>

<p>* Title(vchar(128)):</p>
<p><input type=\"text\" name=\"title\" value=\"" . $article["title"] . "\" class=\"input_text\" /></p>

<p>* Slug(vchar(128)):</p>
<p><input type=\"text\" name=\"slug\" value=\"" . $article["slug"] . "\" class=\"input_text\" /></p>

<p>* Date(datetime):</p>
<p><input type=\"text\" name=\"date\" value=\"" . $article["date"] . "\" class=\"input_text\" /></p>

<p>* Content(longtext):</p>
<p><textarea name=\"content\" class=\"textarea\">" . $article["content"] . "</textarea></p>

<p>* Category:</p>
<p>Availiable categories(only has one):</p>
" . $category_names . "
<p><input type=\"text\" name=\"category_name\" value=\"" . $article["category"]["name"] . "\" class=\"input_text\" /></p>

<p>Tag(seperated by comma and a space):</p>
<p>Availiable tags(seperated multitags by comma and a space):</p>
<p>" . $tag_names . "</p>
<p><input type=\"text\" name=\"tag_name\" value=\"" . $article_tag_names . "\" class=\"input_text\" /></p>

<p>* Keywords(text):</p>
<p><input type=\"text\" name=\"keywords\" value=\"" . $article["keywords"] . "\" class=\"input_text\" /></p>

<p>* Description(text):</p>
<p><textarea name=\"description\" class=\"textarea\">" . $article["description"] . "</textarea></p>

<p><input type=\"submit\" name=\"update\" value=\"Update\" class=\"input_submit\" /></p>
</form >";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }


    private function category_output($result, $categories, $list, $url, $indent, $indent_constant)
    {
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];

        foreach ($categories as $category)
        {
            if (isset($category["son"]))
            {
                $list[] = $indent . "<li><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $category["id"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a></li>
" . $indent . "<ul>
" . $this->category_output($result, $category["son"], array(), $url, $indent . $indent_constant, $indent_constant) . "
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
