<?php
namespace blog\views\admin\file;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class write extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Select file";
        $this->position = array("Select file");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Select file(* is necessary)",
                array()
            ) . "\n\n" .
            html::tag(
                "form",
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "form_stamp", "value" => $this->data["form_stamp"])),
                    array()
                ) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "MAX_FILE_SIZE", "value" => \swdf::$app->config["max_file_size"])),
                    array()
                ) . "\n\n" .

                html::inline_tag("lable", "* Date:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "date", "value" => date("Y-m-d H:i:s"), "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "Name:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "name",  "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* File:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "file", "name" => "file",  "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Host:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "host", "value" => "local", "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Folder:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "folder", "value" => "uploads", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "submit", "name" => "add", "value" => "Add", "class" => "input-submit")),
                    array()
                ),
                array(
                    "enctype" => "multipart/form-data",
                    "action" => url::get(array(\swdf::$app->name, "admin/file.add", ""), array(), ""),
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
