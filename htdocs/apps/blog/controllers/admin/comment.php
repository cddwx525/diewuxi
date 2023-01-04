<?php
namespace blog\controllers\admin;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\lib\Michelf\MarkdownExtra;
use blog\models\comment as comment_model;
use blog\models\article;
use blog\models\tag;
use blog\models\category;
use blog\models\media;
use blog\models\article_tag;

class comment extends controller
{
    /**
     *
     *
     */
    protected function get_behaviors()
    {
        return array(
            array(
                "class" => init::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => array(
                        "common/not_config",
                        array()
                    )
                ),
            ),
            array(
                "class" => user_data::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => array(
                        "common/not_login",
                        array()
                    )
                )
            ),
        );
    }


    /**
     *
     *
     */
    public function list_all()
    {
        $comment = new comment_model();

        $comments = $comment->find_all();

        return array(
            "admin/comment/list_all",
            array(
                "comments" => $comments,
            )
        );
    }


    /**
     *
     *
     */
    public function list_by_article()
    {
        $article = new article();
        $comment = new comment_model();

        if ($article->get_is_id(\swdf::$app->request["get"]["article_id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $article->get_by_id(\swdf::$app->request["get"]["article_id"]);
            $comments = $article->get_comments();

            return array(
                "admin/comment/list_by_article",
                array(
                    "article" => $article,
                    "comments" => $comments,
                )
            );
        }
    }


    /**
     *
     *
     */
    public function write()
    {
        $comment = new comment_model();
        $article = new article();

        if ($comment->get_is_link(\swdf::$app->request["get"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $article->get_by_id(\swdf::$app->request["get"]["article_id"]);
            $comment->get_by_id(\swdf::$app->request["get"]["target_id"]);

            return array(
                "admin/comment/write",
                array(
                    "article" => $article,
                    "comment" => $comment,
                    "form_stamp" => \swdf::$app->data["user"]->update_form_stamp()->record["form_stamp"],
                )
            );
        }
    }


    /**
     *
     *
     */
    public function add()
    {
        $comment = new comment_model();
        $article = new article();

        $ret = $comment->validate_add();
        if ($ret["result"] === FALSE)
        {
            return array(
                "admin/common/message",
                array(
                    "source" => "Add comment",
                    "message" => $ret["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "admin/article.list_all", ""), array(), ""),
                )
            );
        }
        else
        {
            $article->get_by_id(\swdf::$app->request["post"]["article_id"]);

            $comment->add_data();

            return array(
                "admin/comment/add",
                array(
                    "article" => $article,
                    "comment" => $comment,
                )
            );
        }
    }


    /**
     *
     *
     */
    public function delete_confirm()
    {
        $comment = new comment_model();

        if ($comment->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $comment->get_by_id(\swdf::$app->request["get"]["id"]);

            return array(
                "admin/comment/delete_confirm",
                array(
                    "comment" => $comment,
                )
            );
        }
    }


    /**
     *
     *
     */
    public function delete()
    {
        $comment = new comment_model();

        if ($comment->get_is_id(\swdf::$app->request["post"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $comment->get_by_id(\swdf::$app->request["post"]["id"]);

            $ret = $comment->validate_delete();

            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Delete comment",
                        "message" => $ret["message"],
                        "back_url" => url::get(array(\swdf::$app->name, "admin/comment.delete_confirm", ""), array("id" => $comment->record["id"]), ""),
                    )
                );
            }
            else
            {
                $comment->delete_data();

                return array(
                    "admin/comment/delete",
                    array(
                        "comment" => $comment
                    )
                );
            }
        }
    }
}
?>
