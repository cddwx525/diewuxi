<?php
namespace blog\views\admin\media;

use blog\lib\url;
use blog\lib\views\admin_base;

class edit extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];
        $max_file_size = $result["meta_data"]["settings"]["max_file_size"];
        $media = $result["media"];


        $title = "Edit media";
        $position = " > Edit media";

        $media_edit = "<div class=\"content_title border_frame\" >
<h3>Edit media(* must be write)</h3>
</div>

<div id=\"edit\" class=\"border_frame\">
<form enctype=\"multipart/form-data\" action=\"". $url->get(array($app_space_name, "admin/media.update", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>
<p><input type=\"hidden\" name=\"id\" value=\"" . $media["id"] . "\" /></p>

<p><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"" . $max_file_size . "\" /></p>

<p>* Date(datetime):</p>
<p><input type=\"text\" name=\"date\" value=\"" . $media["date"] . "\" class=\"input_text\" /></p>

<p>* File:</p>
<p><input name=\"file\" type=\"file\" class=\"input_text\" /></p>

<p>* Article id(int(11)):</p>
<p><input type=\"text\" name=\"article_id\" value=\"" . $media["article_id"] . "\" class=\"input_text\" /></p>

<p><input type=\"submit\" name=\"update\" value=\"Update\" class=\"input_submit\" /></p>
</form >
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $media_edit . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
