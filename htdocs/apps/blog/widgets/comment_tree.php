<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class comment_tree extends widget
{
    /**
     *
     *
     */
    protected function run($config)
    {
        return $this->get_comment_tree_html($config["data"]);
    }


    /**
     *
     *
     */
    private function get_comment_tree_html($comment_tree)
    {
        if (empty($comment_tree))
        {
            $comment_html = "<p>There is no comments now.</p>";
        }
        else
        {
            $comment_html = $this->recusive_comment_tree_html($comment_tree);
        }

        return $comment_html;
    }


    /**
     *
     *
     */
    private function recusive_comment_tree_html($comment_tree)
    {
        $comment_link_list = array();
        foreach ($comment_tree as $comment)
        {
            if ($comment["author"] === "1")
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
                    html::inline_tag("span", htmlspecialchars($comment["user"]), array()).
                    $author_part .
                    html::inline_tag(
                        "span",
                        is_null($comment["target_id"]) ? "[" . $comment["number"] . "#]" : "",
                        array("class" => "float-right")
                    ) . "\n" .
                    html::tag("div", "", array("class" => "clear-both")),
                    array("class" => "bg-header-line-s")
                ) . "\n\n" .
                html::tag(
                    "div",
                    htmlspecialchars($comment["content"]),
                    array("class" => "block-padding")
                ) . "\n\n" .
                html::tag(
                    "div",
                    html::inline_tag("span", $comment["date"], array("class" => "text-muted")) .
                    html::inline_tag(
                        "span",
                        html::a(
                            "Reply",
                            url::get(
                                array(\swdf::$app->name, "guest/comment.write", ""),
                                array("article_id" => $comment["article_id"], "target_id" => $comment["id"]),
                                ""
                            ),
                            array("class" => "text-padding")
                        ),
                        array()
                    ),
                    array()
                ),
                array("id" => $comment["id"])
            );

            if (! is_null($comment["reply"]))
            {
                $comment_link_list[] = $this->get_comment_tree_html($comment["reply"]);
            }
        }

        return html::tag("ul", implode("\n", $comment_link_list), array());
    }
}
?>
