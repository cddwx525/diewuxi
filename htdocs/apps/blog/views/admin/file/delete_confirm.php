<?php
namespace blog\views\admin\file;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class delete_confirm extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Confirm delete file: [" . $this->data["file"]->record["name"] . "]";
        $this->position = array("Confirm delete file");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Confirm delete file: [" . htmlspecialchars($this->data["file"]->record["name"]) . "]",
                array()
            ) . "\n" .
            html::inline_tag(
                "p",
                "File information:",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Id: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["file"]->record["id"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Date: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["file"]->record["date"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "name: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["file"]->record["name"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Related articles: ", array()) .
                        html::inline_tag("span", $this->data["file"]->get_article_count(), array()),
                        array()
                    ),
                    array()
                ),
                array()
            ) . "\n\n" .
            html::tag(
                "form",
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "id", "value" => $this->data["file"]->record["id"])),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "Input user password to confirm the action: ", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "password", "name" => "password", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "submit", "name" => "confirm", "value" => "Confirm", "class" => "input-submit")),
                    array()
                ),
                array(
                    "action" => url::get(array(\swdf::$app->name, "admin/file.delete", ""), array(), ""),
                    "method" => "post"
                )
            ),
            array()
        );
    }


    /**
     *
     *
     */
    protected function set_text()
    {
        $this->text = "";
    }
}
?>
