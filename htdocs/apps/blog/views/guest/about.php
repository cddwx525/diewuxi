<?php
namespace blog\views\guest;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\guest_base;

class about extends guest_base
{
    protected function set_items()
    {
        $this->css = array(
            url::get_static(\swdf::$app->name, "css/github-markdown.css"),
        );
        $this->title = "About";
        $this->position = array("About");
        $this->main = "<div>
    <h3>Home</h3>

    <div class=\"markdown-body\">
" . html::tidy($this->data["about_page"]["content"], 2) . "
    </div>
</div>";
    }

    protected function set_text()
    {
        $this->text = "";
    }
}
?>
