<?php
namespace blog\views\admin\file;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class edit extends admin_base
{
    /**
     *
     *
     */
    public function set_items()
    {
        $this->title = "Edit file: [" . $this->data["file"]->record["name"] . "]";
        $this->position = array("Edit file");
        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Edit file: [" . htmlspecialchars($this->data["file"]->record["name"]) . "]",
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
                    html::mono_tag("input", array("type" => "hidden", "name" => "id", "value" => $this->data["file"]->record["id"])),
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "MAX_FILE_SIZE", "value" => \swdf::$app->config["max_file_size"])),
                    array()
                ) . "\n\n" .

                html::inline_tag("lable", "* Date:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "date", "value" => $this->data["file"]->record["date"], "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Name:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "name", "value" => $this->data["file"]->record["name"], "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Select file:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "file", "name" => "file", "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Host:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "host", "value" => $this->data["file"]->record["host"], "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Folder:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "folder", "value" => $this->data["file"]->record["folder"], "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "submit", "name" => "update", "value" => "Update", "class" => "input-submit")),
                    array()
                ),
                array(
                    "enctype" => "multipart/form-data",
                    "action" => url::get(array(\swdf::$app->name, "admin/file.update", ""), array(), ""),
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
        $this->text = "Form_stamp: " . $this->data["form_stamp"];
    }

}
?>
