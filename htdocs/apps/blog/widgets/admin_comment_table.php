<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class admin_comment_table extends widget
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
    private function get_html($comments)
    {
        $comment_link_list = array();

        foreach ($comments as $key => $comment)
        {
            if (($key + 1) % 2 === 0)
            {
                $alternate = "even";
            }
            else
            {
                $alternate = "odd";
            }

            $comment_link_list[] = html::tag(
                "tr",
                html::inline_tag("td", $comment->record["id"], array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($comment->record["number"]), array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($comment->record["target_id"]), array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($comment->record["user"]), array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($comment->record["author"]), array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($comment->record["mail"]), array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($comment->record["site"]), array()) . "\n" .
                html::inline_tag("td", $comment->record["date"], array()) . "\n" .
                html::inline_tag(
                    "td",
                    html::a(
                        htmlspecialchars($comment->get_article()->record["title"]),
                        url::get(
                            array(\swdf::$app->name, "admin/article.show", ""),
                            array("id" => $comment->record["article_id"]),
                            $comment->record["id"]
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
                            array(\swdf::$app->name, "admin/comment.delete_confirm", ""),
                            array("id" => $comment->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ),
                    array()
                ),
                array("class" => $alternate)
            );
        }
        $comment_links = implode("\n", $comment_link_list);

        $result = html::tag(
            "table",
            html::tag(
                "tr",
                html::inline_tag("th", "Id", array()) . "\n" .
                html::inline_tag("th", "Number", array()) . "\n" .
                html::inline_tag("th", "Target", array()) . "\n" .
                html::inline_tag("th", "User", array()) . "\n" .
                html::inline_tag("th", "Author", array()) . "\n" .
                html::inline_tag("th", "Mail", array()) . "\n" .
                html::inline_tag("th", "Site", array()) . "\n" .
                html::inline_tag("th", "Date", array()) . "\n" .
                html::inline_tag("th", "Article", array()) . "\n" .
                html::inline_tag("th", "Operations", array()),
                array()
            ) . "\n" .
            $comment_links,
            array("class" => "alternate-table")
        );

        return $result;
    }
}
?>
