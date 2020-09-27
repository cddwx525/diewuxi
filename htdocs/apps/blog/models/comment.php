<?php
namespace blog\models;

use swdf\base\model;
use blog\models\article;

class comment extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "comment";
    }



    /**
     *
     *
     */
    public function get_comment($comment)
    {
        return $comment;
    }


    /**
     *
     *
     */
    public function get_by_id($id)
    {
        return $this->get_comment($this->select_by_id($id)["record"]);
    }


    /**
     *
     *
     */
    public function hierarchy($comments)
    {
        foreach ($comments as $key => $comment)
        {
            $where = array(
                array(
                    "field" => "target_id",
                    "value" => (int) $comment["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $subcomments = $this->where($where)->order(array("`date` ASC"))->select()["record"];
            if (! empty($subcomments))
            {
                $comments[$key]["reply"] = $this->hierarchy($subcomments);
            }
            else
            {
                $comments[$key]["reply"] = NULL;
            }
        }
        return $comments;
    }


    /**
     *
     *
     */
    public function get_is_link($data)
    {
        $article_model = new article();

        if (
            (! isset($data["article_id"])) ||
            (! isset($data["target_id"]))
        )
        {
            return FALSE;
        }
        else
        {
            if (
                ($data["article_id"] === "") ||
                ($data["target_id"] === "")
            )
            {
                return FALSE;
            }
            else
            {
                if ($data["target_id"] === "NULL")
                {
                    return FALSE;
                }
                else
                {
                    if (
                        ($article_model->select_by_id((int) $data["article_id"])["record"] === FALSE) ||
                        ($this->select_by_id((int) $data["target_id"])["record"] === FALSE)
                    )
                    {
                        return FALSE;
                    }
                    else
                    {
                        if ($this->select_by_id((int) $data["target_id"])["record"]["article_id"] != $data["article_id"])
                        {
                            return FALSE;
                        }
                        else
                        {
                            return TRUE;
                        }
                    }
                }
            }
        }
    }


    /**
     *
     *
     */
    public function validate($data)
    {
        $article_model = new article();

        if (
            (! isset($data["article_id"])) ||
            (! isset($data["target_id"])) ||
            (! isset($data["user"])) ||
            (! isset($data["mail"])) ||
            (! isset($data["content"]))
        )
        {
            return array(
                "result" => FALSE,
                "message" => "Form uncomplete, one or more field not set."
            );
        }
        else
        {

            if (
                ($data["article_id"] === "") ||
                ($data["target_id"] === "") ||
                ($data["user"] === "") ||
                ($data["mail"] === "") ||
                ($data["content"] === "")
            )
            {
                return array(
                    "result" => FALSE,
                    "message" => "Form uncomplete, one or more necessary field is empty."
                );
            }
            else
            {
                if ($data["target_id"] == "NULL")
                {
                    if ($article_model->select_by_id((int) $data["article_id"])["record"] === FALSE)
                    {
                        return array(
                            "result" => FALSE,
                            "message" => "Article id wrong."
                        );
                    }
                    else
                    {
                        return array(
                            "result" => TRUE,
                        );
                    }
                }
                else
                {
                    if (
                        ($article_model->select_by_id((int) $data["article_id"])["record"] === FALSE) ||
                        ($this->select_by_id((int) $data["target_id"])["record"] === FALSE)
                    )
                    {
                        return array(
                            "result" => FALSE,
                            "message" => "Article id or target id not exists."
                        );
                    }
                    else
                    {
                        if ($this->select_by_id((int) $data["target_id"])["record"]["article_id"] != $data["article_id"])
                        {
                            return array(
                                "result" => FALSE,
                                "message" => "Article id and target id not match."
                            );
                        }
                        else
                        {
                            return array(
                                "result" => TRUE,
                            );
                        }
                    }
                }
            }
        }
    }


    /**
     *
     *
     */
    public function add_data($data)
    {
        if ($data["target_id"] === "NULL")
        {
            $target_id = NULL;

            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $data["article_id"],
                    "operator" => "=",
                    "condition" => "AND",
                ),
                array(
                    "field" => "target_id",
                    "operator" => "IS NULL",
                    "condition" => "",
                ),
            );
            $comment_last = $this->where($where)->order(array("`number` DESC"))->select_first()["record"];
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
            $target_id = (int) $data["target_id"];
            $number = NULL;
        }

        $data = array(
            "date"          => date("Y-m-d H:i:s"),
            "number"        => $number,

            "user"          => $data["user"],
            "mail"          => $data["mail"],
            "site"          => $data["site"],
            "content"       => $data["content"],

            "target_id"     => $target_id,
            "article_id"    => (int) $data["article_id"],
        );

        $result = $this->add($data);

        return $result;
    }
}
?>
