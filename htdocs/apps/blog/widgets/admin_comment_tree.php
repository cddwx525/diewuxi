<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class admin_comment_tree extends widget
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
        if (empty($comments) === TRUE)
        {
            $html = "<p>There is no comments now.</p>";
        }
        else
        {
            $html = $this->recusive_comments($comments);
        }

        return $html;
    }


    /**
     *
     *
     */
    private function recusive_comments($comments)
    {
        $comment_link_list = array();
        foreach ($comments as $one_comment)
        {
            if ($one_comment->record["author"] === "1")
            {
                $author_part = html::inline_tag("span", "[Author]", array("class" => "text-warning text-padding"));
            }
            else
            {
                $author_part = "";
            }

            $comment_link_list[] = html::tag(
                "li",
                html::tag(
                    "div",
                    html::inline_tag("span", htmlspecialchars($one_comment->record["user"]), array()) .
                    $author_part .
                    html::inline_tag("span", "[" . htmlspecialchars($one_comment->record["mail"]) . "]", array("class" => "text-padding")) .
                    html::inline_tag("span", "[" . htmlspecialchars($one_comment->record["site"]) . "]", array("class" => "text-padding")) .
                    html::inline_tag(
                        "span",
                        is_null($one_comment->record["target_id"]) ? "[" . $one_comment->record["number"] . "#]" : "",
                        array("class" => "float-right")
                    ) . "\n" .
                    html::tag("div", "", array("class" => "clear-both")),
                    array("class" => "bg-header-line-s")
                ) . "\n\n" .
                html::tag(
                    "div",
                    htmlspecialchars($one_comment->record["content"]),
                    array("class" => "block-padding")
                ) . "\n\n" .
                html::tag(
                    "div",
                    html::inline_tag("span", $one_comment->record["date"], array("class" => "text-muted")) .
                    html::inline_tag(
                        "span",
                        html::a(
                            "Reply",
                            url::get(
                                array(\swdf::$app->name, "admin/comment.write", ""),
                                array("article_id" => $one_comment->record["article_id"], "target_id" => $one_comment->record["id"]),
                                ""
                            ),
                            array("class" => "text-padding")
                        ),
                        array()
                    ) .
                    html::inline_tag(
                        "span",
                        html::a(
                            "Delete",
                            url::get(
                                array(\swdf::$app->name, "admin/comment.delete_confirm", ""),
                                array("id" => $one_comment->record["id"]),
                                ""
                            ),
                            array("class" => "text-padding-s")
                        ),
                        array()
                    ),
                    array()
                ),
                array("id" => $one_comment->record["id"])
            );

            $reply = $one_comment->get_reply();

            if (empty($reply) === FALSE)
            {
                $comment_link_list[] = $this->recusive_comments($reply);
            }
            else
            {
            }
        }

        return html::tag("ul", implode("\n", $comment_link_list), array());
    }
}
?>
