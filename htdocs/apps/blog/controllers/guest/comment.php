<?php
namespace blog\controllers\guest;

use blog\lib\url;
use blog\lib\controllers\guest_base;
use blog\models\article as article_model;
use blog\models\category as category_model;
use blog\models\comment as comment_model;

class comment extends guest_base
{
    public function write($parameters)
    {
        $url = new url();
        $table_comment = new comment_model();
        $table_article = new article_model();
        $table_category = new category_model();

        //Filter config.
        if ($this->config === FALSE)
        {
            $view_name = "common/not_config";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Filter wrong id.
        if (
            (! isset($parameters["get"]["article_id"])) ||
            (! isset($parameters["get"]["target_id"])) ||
            ($parameters["get"]["article_id"] === "") ||
            ($table_article->select_by_id((int) $parameters["get"]["article_id"])["record"] === FALSE) ||
            ($parameters["get"]["target_id"] === "") ||
            ($table_comment->select_by_id((int) $parameters["get"]["target_id"])["record"] === FALSE)
        )
        {
            $view_name = "common/not_found";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Get article record.
        $article = $table_article->select_by_id((int) $parameters["get"]["article_id"])["record"];

        // Add category data to article.
        $article["category"] = $table_category->select_by_id($article["category_id"])["record"];

        // Get comment record.
        $comment = $table_comment->select_by_id((int) $parameters["get"]["target_id"])["record"];

        $view_name = "guest/comment/write";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "article" => $article,
            "comment" => $comment,
        );
    }


    public function add($parameters)
    {
        $url = new url();
        $table_comment = new comment_model();
        $table_article = new article_model();
        $table_category = new category_model();

        //Filter config.
        if ($this->config === FALSE)
        {
            $view_name = "common/not_config";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Filter wrong id.
        if (
            (! isset($parameters["post"]["article_id"])) ||
            ($parameters["post"]["article_id"] === "") ||
            ($table_article->select_by_id((int) $parameters["post"]["article_id"])["record"] === FALSE) ||
            (! isset($parameters["post"]["target_id"])) ||
            ($parameters["post"]["target_id"] === "") ||
            (
                ($parameters["post"]["target_id"] != "NULL") &&
                ($table_comment->select_by_id((int) $parameters["post"]["target_id"])["record"] === FALSE)
            )
        )
        {
            $view_name = "guest/comment/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Get article.
        $article = $table_article->select_by_id((int) $parameters["post"]["article_id"])["record"];

        // Add category data to article.
        $article["category"] = $table_category->select_by_id($article["category_id"])["record"];

        // Filter uncomplete.
        if (
            (! isset($parameters["post"]["user"])) ||
            ($parameters["post"]["user"] === "") ||
            (! isset($parameters["post"]["mail"])) ||
            ($parameters["post"]["mail"] === "") ||
            (! isset($parameters["post"]["content"])) ||
            ($parameters["post"]["content"] === "")
        )
        {
            $view_name = "guest/comment/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "UNCOMPLETE",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Get target_id and number.
        if ($parameters["post"]["target_id"] === "NULL")
        {
            $target_id = NULL;

            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $parameters["post"]["article_id"],
                    "operator" => "=",
                    "condition" => "AND",
                ),
                array(
                    "field" => "target_id",
                    "operator" => "IS NULL",
                    "condition" => "",
                ),
            );
            $comment_last = $table_comment->where($where)->order(array("`number` DESC"))->select_first()["record"];
            if ($comment_last === FALSE)
            {
                $number = 1;
            }
            else
            {
                $number = $comment_last["number"] + 1;
            }
        }
        else
        {
            $target_id = (int) $parameters["post"]["target_id"];
            $number = NULL;
        }

        // Add comment.
        $data = array(
            "date"          => date("Y-m-d H:i:s"),
            "number"        => $number,
            "user"          => $parameters["post"]["user"],
            "mail"          => $parameters["post"]["mail"],
            "site"          => $parameters["post"]["site"],
            "content"       => $parameters["post"]["content"],

            "target_id"     => $target_id,
            "article_id"    => (int) $parameters["post"]["article_id"],
        );

        try
        {
            $comment_add = $table_comment->add($data);
        }
        catch (\PDOException $e)
        {
            // Filter comment add fail.
            $view_name = "guest/comment/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "COMMENT_ADD_FAIL",
                "parameters" => $parameters,
            );
        }

        $state = "SUCCESS";
        $view_name = "guest/comment/add";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => $state,
            "parameters" => $parameters,
            "article" => $article,
        );
    }
}
?>
