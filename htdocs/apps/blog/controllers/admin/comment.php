<?php
namespace blog\controllers\admin;

use blog\lib\url;
use blog\lib\controllers\admin_base;
use blog\models\article as article_model;
use blog\models\category as category_model;
use blog\models\comment as comment_model;
use blog\models\user as user_model;

class comment extends admin_base
{
    public function list_all($parameters)
    {
        $table_article = new article_model();
        $table_comment = new comment_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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

        // Get comments.
        $comments = $table_comment->order(array("`date` DESC"))->select()["record"];

        // Add article data to comment.
        foreach ($comments as $key => $comment)
        {
            $comment["article"] = $table_article->select_by_id((int) $comment["article_id"])["record"];

            $comments[$key] = $comment;
        }

        $view_name = "admin/comment/list_all";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "comments" => $comments,
        );
    }


    public function write($parameters)
    {
        $url = new url();
        $table_comment = new comment_model();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_user = new user_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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
            ($parameters["get"]["article_id"] === "") ||
            ($table_article->select_by_id((int) $parameters["get"]["article_id"])["record"] === FALSE) ||
            (! isset($parameters["get"]["target_id"])) ||
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

        // Generate form stamp.
        session_start(["read_and_close" => TRUE,]);
        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));

        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $table_user->where($where)->update(array("form_stamp" => $form_stamp,));

        $view_name = "admin/comment/write";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "article" => $article,
            "comment" => $comment,
            "form_stamp" => $form_stamp,
        );
    }


    public function add($parameters)
    {
        $url = new url();
        $table_comment = new comment_model();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_user = new user_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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
            $view_name = "admin/comment/add";

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

        // Get user record.
        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $one_user = $table_user->where($where)->select_first()["record"];

        // Filter wrong form stamp.
        if (
            (! isset($parameters["post"]["form_stamp"])) ||
            ($parameters["post"]["form_stamp"] != $one_user["form_stamp"])
        )
        {
            $view_name = "admin/comment/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "XSRF",
                "parameters" => $parameters,
                "article" => $article,
            );
        }
        else
        {
        }

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
            $view_name = "admin/comment/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "UNCOMPLETE",
                "parameters" => $parameters,
                "article" => $article,
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

        // Get author.
        if (isset($parameters["post"]["author"]))
        {
            $author = TRUE;
        }
        else
        {
            $author = FALSE;
        }

        // Add comment.
        $data = array(
            "date"          => date("Y-m-d H:i:s"),
            "number"        => $number,
            "user"          => $parameters["post"]["user"],
            "mail"          => $parameters["post"]["mail"],
            "site"          => $parameters["post"]["site"],
            "content"       => $parameters["post"]["content"],
            "author"        => $author,

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
            $view_name = "admin/comment/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "COMMENT_ADD_FAIL",
                "parameters" => $parameters,
                "article" => $article,
            );
        }

        $view_name = "admin/comment/add";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
            "article" => $article,
        );
    }


    public function delete_confirm($parameters)
    {
        $url = new url();
        $table_comment = new comment_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_comment->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
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

        // Get comment record.
        $comment = $table_comment->select_by_id((int) $parameters["get"]["id"])["record"];

        $view_name = "admin/comment/delete_confirm";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "comment" => $comment,
        );
    }


    public function delete($parameters)
    {
        $url = new url();
        $table_comment = new comment_model();
        $table_user = new user_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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
            (! isset($parameters["post"]["id"])) ||
            ($parameters["post"]["id"] === "") ||
            ($table_comment->select_by_id((int) $parameters["post"]["id"])["record"] === FALSE)
        )
        {
            $view_name = "admin/comment/delete";

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

        // Get user record.
        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $one_user = $table_user->where($where)->select_first()["record"];

        // Filter wrong pasword.
        if (password_verify($parameters["post"]["password"], $one_user["password_hash"]) === FALSE)
        {
            $view_name = "admin/comment/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "PASSWORD_WRONG",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Delete comment.
        try
        {
            $comment_delete = $table_comment->delete_by_id((int) $parameters["post"]["id"]);
        }
        catch (\PDOException $e)
        {
            // Filter main comment delete fail.
            $view_name = "admin/comment/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "MAIN_COMMENT_DELETE_FAIL",
                "parameters" => $parameters,
            );
        }

        // Delete subcomments.
        $where = array(
            array(
                "field" => "target_id",
                "value" => (int) $parameters["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $state = $this->comment_delete_hierarchy($table_comment->where($where)->select()["record"], $table_comment);

        $view_name = "admin/comment/delete";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => $state,
            "parameters" => $parameters,
        );
    }


    private function comment_delete_hierarchy($comments, $table_comment)
    {
        foreach ($comments as $comment)
        {
            try
            {
                $comment_delete = $table_comment->delete_by_id((int) $comment["id"]);
            }
            catch (\PDOException $e)
            {
                return "SUBCOMMENT_DELETE_FAIL";
            }

            $where = array(
                array(
                    "field" => "target_id",
                    "value" => (int) $comment["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $subcomments = $table_comment->where($where)->order(array("`date` ASC"))->select()["record"];
            if (! empty($subcomments))
            {
                $state = $this->comment_delete_hierarchy($subcomments, $table_comment);
            }
            else
            {
        }
        }

        return "SUCCESS";
    }
}
?>
