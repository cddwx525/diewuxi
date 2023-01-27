<?php
namespace main\views\program;

use swdf\helpers\html;
use swdf\helpers\url;
use main\views\layouts\base;

class cwgcal extends base
{
    public function set_items()
    {
        $this->title = "CWG calculate tool";
        $this->position = array("CWG calculate tool");

        $this->css = array(url::get_static("css/github-markdown.css"),);

        if ($this->data["type"] === "voltage")
        {
            $html_type = html::inline_tag(
                "td",
                html::mono_tag("input", array("type" => "radio", "name" => "type", "value" => "voltage", "checked" => "checked", "id" => "v", "class" => "")) .
                html::inline_tag("label", "Voltage", array("for" => "v")) .
                html::mono_tag("input", array("type" => "radio", "name" => "type", "value" => "current", "id" => "c", "class" => "")) .
                html::inline_tag("label", "Current", array("for" => "c")),
                array()
            );
        }
        else
        {
            $html_type = html::inline_tag(
                "td",
                html::mono_tag("input", array("type" => "radio", "name" => "type", "value" => "voltage", "id" => "v", "class" => "")) .
                html::inline_tag("label", "Voltage", array("for" => "v")) .
                html::mono_tag("input", array("type" => "radio", "name" => "type", "value" => "current", "checked" => "checked", "id" => "c", "class" => "")) .
                html::inline_tag("label", "Current", array("for" => "c")),
                array()
            );
        }

        $this->main = html::tag(
            "div",
            html::tag(
                "div",
                html::tag(
                    "form",
                    html::tag(
                        "table",
                        html::tag(
                            "tr",
                            html::inline_tag("td", "Peak value:", array("class" => "")) . "\n" .
                            html::inline_tag(
                                "td",
                                html::mono_tag("input", array("type" => "text", "name" => "peak_value", "value" => $this->data["peak_value"], "class" => "")),
                                array()
                            ),
                            array()
                        ) . "\n" .
                        html::tag(
                            "tr",
                            html::inline_tag("td", "Type:", array("class" => "")) . "\n" . $html_type,
                            array()
                        ) . "\n" .
                        html::tag(
                            "tr",
                            html::inline_tag("td", "", array()) . "\n" .
                            html::inline_tag(
                                "td",
                                html::mono_tag("input", array("type" => "submit", "name" => "calculate", "value" => "Calculate", "class" => "")),
                                array()
                            ),
                            array()
                        ),
                        array("class" => "table-noborder")
                    ),
                    array(
                        "action" => url::get(array(\swdf::$app->name, "program.cwgcal", ""), array(), ""),
                        "method" => "post"
                    )
                ),
                array()
            ) . "\n\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::mono_tag("br", array()) . "\n" .
            html::tag(
                "div",
                html::tag(
                    "table",
                    html::tag(
                        "tr",
                        html::inline_tag("td", "Half value:", array("class" => "")) . "\n" .
                        html::inline_tag("td", "<span>" . $this->data["half"] . "</span>", array()),
                        array()
                    ) . "\n" .
                    html::tag(
                        "tr",
                        html::inline_tag("td", "V1:", array("class" => "")) . "\n" .
                        html::inline_tag("td", "<span>" . $this->data["v1"] . "</span>", array()),
                        array()
                    ) . "\n" .
                    html::tag(
                        "tr",
                        html::inline_tag("td", "V2:", array("class" => "")) . "\n" .
                        html::inline_tag("td", "<span>" . $this->data["v2"] . "</span>", array()),
                        array()
                    ),
                    array()
                ),
                array()
            ) . "\n\n" .
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
