<?php
namespace main\views\program;

use swdf\helpers\html;
use swdf\helpers\url;
use main\views\layouts\base;

class index extends base
{
    public function set_items()
    {
        $this->title = "Programs";
        $this->position = array("Programs");

        $this->css = array(url::get_static("css/github-markdown.css"),);

        $this->main = html::tag(
            "div",
            html::tag(
                "ul",
                html::inline_tag(
                    "li",
                    html::a(
                        "CWG waveshape parameter caculate tool",
                        url::get(array(\swdf::$app->name, "program.cwgcal", ""), array(), ""),
                        array()
                    ),
                    array()
                ),
                array()
            ) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()),
            array()
        );

    }

    public function set_text()
    {
         $this->text = "";
    }
}
?>
