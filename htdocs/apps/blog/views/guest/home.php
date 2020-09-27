<?php
namespace blog\views\guest;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\guest_base;

class home extends guest_base
{
    protected function set_items()
    {
        $this->css = array(
            url::get_static(\swdf::$app->name, "css/github-markdown.css"),
        );
        $this->title = "Home";
        $this->position = array("Home");
        $this->main = "<div>
    <h3>Home</h3>

    <div class=\"markdown-body\">
" . html::tidy($this->data["home_page"]["content"], 2) . "
    </div>
</div>";
    }

    protected function set_text()
    {
        $this->text = "";
    }
}
?>
