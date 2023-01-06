<?php
namespace main\views;

use swdf\helpers\html;
use swdf\helpers\url;
use main\views\layouts\base;

class screenshot_v1_0 extends base
{
    public function set_items()
    {
        $this->title = "Site v1.0 screenshot";
        $this->position = array("Site v1.0 screenshot");

        $this->css = array(url::get_static("css/github-markdown.css"),);

        $this->main = html::tag(
            "div",
            html::tag(
                "div",
                html::a(
                    html::mono_tag(
                        "img",
                        array("src" => url::get_static("image/site_screenshot/v1.0/Screenshot_2022-03-06_21-35-00.png"), "alt" => htmlspecialchars("Home")),
                    ),
                    url::get_static("image/site_screenshot/v1.0/Screenshot_2022-03-06_21-35-00.png"),
                    array()
                ) . "\n" .
                html::a(
                    html::mono_tag(
                        "img",
                        array("src" => url::get_static("image/site_screenshot/v1.0/Screenshot_2022-03-06_21-36-06.png"), "alt" => htmlspecialchars("Blog home")),
                    ),
                    url::get_static("image/site_screenshot/v1.0/Screenshot_2022-03-06_21-36-06.png"),
                    array()
                ) . "\n" .
                html::a(
                    html::mono_tag(
                        "img",
                        array("src" => url::get_static("image/site_screenshot/v1.0/Screenshot_2022-03-06_21-36-26.png"), "alt" => htmlspecialchars("Blog articles")),
                    ),
                    url::get_static("image/site_screenshot/v1.0/Screenshot_2022-03-06_21-36-26.png"),
                    array()
                ),
                array("class" => "markdown-body")
            ),
            array()
        );

    }

    public function set_text()
    {
         $this->text = "";
    }
}
?>
