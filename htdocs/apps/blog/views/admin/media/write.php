<?php
namespace blog\views\admin\media;

use blog\lib\url;
use blog\lib\views\admin_base;

class write extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];
        $max_file_size = $result["meta_data"]["settings"]["max_file_size"];


        $title = "Write media";
        $position = " > Write media</a>";


        $media_write = "<div class=\"content_title border_frame\" >
<h3>Write media(* must be write)</h3>
</div>

<div id=\"write\" class=\"border_frame\">
<form enctype=\"multipart/form-data\" action=\"". $url->get(array($app_space_name, "admin/media.add", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>

<p><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"" . $max_file_size . "\" /></p>

<p>* Date(datetime):</p>
<p><input type=\"text\" name=\"date\" value=\"" . date("Y-m-d H:i:s") . "\" class=\"input_text\" /></p>

<p>* File:</p>
<p><input name=\"file\" type=\"file\" class=\"input_text\" /></p>

<p>* Article id(int(11)):</p>
<p><input type=\"text\" name=\"article_id\" value=\"\" class=\"input_text\" /></p>

<p><input type=\"submit\" name=\"add\" value=\"Add\" class=\"input_submit\" /></p>
</form >
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $media_write . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
