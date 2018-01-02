<?php
namespace blog\views\common;

use blog\lib\url;
use blog\lib\views\simple;

class already_login extends simple
{
    public function get_items($result)
    {
        $url = new url();
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Already login";

        $position = " > Already login";

        $content = "<div id=\"content_title\" class=\"border_frame\">
<h3>Already login!</h3>
</div>

<div class=\"border_frame\">
<p>Go to home: <a href=\"" . $url->get(array($app_space_name, "admin/home.show", ""), array(), "") . "\">Home</a></p>
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
