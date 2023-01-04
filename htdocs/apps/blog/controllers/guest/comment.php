<?php
namespace blog\controllers\guest;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\side_data;
use blog\models\article;
use blog\models\comment as comment_model;

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
                "class" => side_data::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => TRUE,
                )
            ),
        );
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
                "common/not_found",
                array()
            );
        }
        else
        {
            $article = $article->get_by_id(\swdf::$app->request["get"]["article_id"]);
            $comment = $comment->get_by_id(\swdf::$app->request["get"]["target_id"]);

            return array(
                "guest/comment/write",
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
    public function add()
    {
        $comment = new comment_model();
        $article = new article();

        $ret = $comment->guest_validate_add();
        if ($ret["result"] === FALSE)
        {
            return array(
                "common/message",
                array(
                    "source" => "Add comment",
                    "message" => $ret["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "guest/home.show", ""), array(), ""),
                )
            );
        }
        else
        {
            $article = $article->get_by_id(\swdf::$app->request["post"]["article_id"]);

            $comment->guest_add_data();

            return array(
                "guest/comment/add",
                array(
                    "article" => $article,
                    "comment" => $comment,
                )
            );
        }
    }
}
?>
