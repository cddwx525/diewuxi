<?php
namespace blog\controllers\guest;

use swdf\base\controller;
use blog\filters\config_state;
use blog\filters\init;
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
                "class" => config_state::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => array(
                        "common/not_conig",
                        array()
                    )
                ),
            ),
            array(
                "class" => init::class,
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
        $comment_model = new comment_model();
        $article_model = new article();

        if (! $comment_model->get_is_link(\swdf::$app->request["get"]))
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $article = $article_model->get_by_id((int) \swdf::$app->request["get"]["article_id"]);
            $comment = $comment_model->get_by_id((int) \swdf::$app->request["get"]["target_id"]);

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
        $comment_model = new comment_model();
        $article_model = new article();

        $validate = $comment_model->validate(\swdf::$app->request["post"]);
        if (! $validate["result"])
        {
            return array(
                "common/message",
                array(
                    "source" => "Add comment",
                    "message" => $validate["message"],
                )
            );
        }
        else
        {
            $article = $article_model->get_by_id((int) \swdf::$app->request["post"]["article_id"]);

            $result = $comment_model->add_data(\swdf::$app->request["post"]);

            return array(
                "guest/comment/add",
                array(
                    "article" => $article,
                    "last_id" => $result["last_id"],
                )
            );
        }
    }
}
?>
