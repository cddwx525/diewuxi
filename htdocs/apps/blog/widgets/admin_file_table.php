<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class admin_file_table extends widget
{
    /**
     *
     *
     */
    protected function run($config)
    {
        return $this->get_html($config["data"]);
    }


    /**
     *
     *
     */
    private function get_html($files)
    {
        $file_link_list = array();

        foreach ($files as $key => $file)
        {
            if (($key + 1) % 2 === 0)
            {
                $alternate = "even";
            }
            else
            {
                $alternate = "odd";
            }

            $file_link_list[] = html::tag(
                "tr",
                html::inline_tag("td", $file->record["id"], array()) . "\n" .
                html::inline_tag("td", $file->record["date"], array()) . "\n" .
                html::inline_tag("td", $file->record["name"], array()) . "\n" .
                html::inline_tag(
                    "td",
                    html::a(
                        "Related articles",
                        url::get(
                            array(\swdf::$app->name, "admin/article.list_by_file", ""),
                            array("file_id" => $file->record["id"]),
                            ""
                        ),
                        array()
                    ),
                    array()
                ) . "\n" .
                html::inline_tag(
                    "td",
                    html::a(
                        "Delete",
                        url::get(
                            array(\swdf::$app->name, "admin/file.delete_confirm", ""),
                            array("id" => $file->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ) .
                    html::a(
                        "Edit",
                        url::get(
                            array(\swdf::$app->name, "admin/file.edit", ""),
                            array("id" => $file->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ) .
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "admin/file.show", ""),
                            array("id" => $file->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ),
                    array()
                ),
                array("class" => $alternate)
            );
        }
        $file_links = implode("\n", $file_link_list);

        $result = html::tag(
            "table",
            html::tag(
                "tr",
                html::inline_tag("th", "Id", array()) . "\n" .
                html::inline_tag("th", "Date", array()) . "\n" .
                html::inline_tag("th", "File", array()) . "\n" .
                html::inline_tag("th", "Articles", array()) . "\n" .
                html::inline_tag("th", "Operations", array()),
                array()
            ) . "\n" .
            $file_links,
            array("class" => "alternate-table")
        );

        return $result;
    }
}
?>
