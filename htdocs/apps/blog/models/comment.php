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



       //$comment["article"] = $this->get_article($comment);


    /**
     *
     *
     */
    public function get_by_id($id)
    {
        $this->record = $this->select_by_id($id)["record"];

        return $this;
    }


    /**
     *
     *
     */
    public function find_all()
    {
        $records = $this->order(array("`date` DESC"))->select()["record"];

        $comments = array();
        foreach ($records as $key => $item)
        {
            $one_comment = new comment();
            $one_comment->record = $item;
            $comments[$key] = $one_comment;
        }

        return $comments;
    }


    /**
     *
     *
     */
    public function get_article()
    {
        $article = new article();

        return $article->get_by_id($this->record["article_id"]);
    }



    /**
     *
     *
     */
    public function get_reply()
    {
        $where = array(
            array(
                "field" => "target_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        $records = $this->where($where)->order(array("`date` ASC"))->select()["record"];

        $comments = array();
        foreach ($records as $key => $item)
        {
            $one_comment = new comment();
            $one_comment->record = $item;
            $comments[$key] = $one_comment;
        }

        return $comments;
    }



    ///**
    // *
    // *
    // */
    //public function hierarchy($comments)
    //{
    //    foreach ($comments as $key => $item)
    //    {
    //        $where = array(
    //            array(
    //                "field" => "target_id",
    //                "value" => (int) $item->record["id"],
    //                "operator" => "=",
    //                "condition" => "",
    //            ),
    //        );
    //        $records = $this->where($where)->order(array("`date` ASC"))->select()["record"];

    //        $sub_comments = array();
    //        foreach ($records as $key => $item)
    //        {
    //            $one_comment = new comment();
    //            $one_comment->record = $item;
    //            $sub_comments[$key] = $one_comment;
    //        }

    //        if (! empty($subcomments))
    //        {
    //            $comments[$key]["reply"] = $this->hierarchy($subcomments);
    //        }
    //        else
    //        {
    //            $comments[$key]["reply"] = NULL;
    //        }
    //    }
    //    return $comments;
    //}




    /**
     *
     *
     */
    public function get_is_link()
    {
        $article = new article();

        if (
            (isset(\swdf::$app->request["get"]["article_id"])  === FALSE) ||
            (isset(\swdf::$app->request["get"]["target_id"])   === FALSE)
        )
        {
            return FALSE;
        }
        else
        {
            if (
                (\swdf::$app->request["get"]["article_id"]     === "") ||
                (\swdf::$app->request["get"]["target_id"]      === "")
            )
            {
                return FALSE;
            }
            else
            {
                if (\swdf::$app->request["get"]["target_id"] === "NULL")
                {
                    return FALSE;
                }
                else
                {
                    if (
                        ($article->select_by_id(\swdf::$app->request["get"]["article_id"])["record"] === FALSE) ||
                        ($this->select_by_id(\swdf::$app->request["get"]["target_id"])["record"] === FALSE)
                    )
                    {
                        return FALSE;
                    }
                    else
                    {
                        if ($this->select_by_id(\swdf::$app->request["get"]["target_id"])["record"]["article_id"] !== \swdf::$app->request["get"]["article_id"])
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
    public function get_is_id($id)
    {
        if (
            (isset($id) === FALSE)
        )
        {
            return FALSE;
        }
        else
        {
            if (
                ($id === "")
            )
            {
                return FALSE;
            }
            else
            {
                if (
                    ($this->select_by_id($id)["record"] === FALSE)
                )
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


    /**
     *
     *
     */
    public function guest_validate_add()
    {
        return $this->validate();
    }




    /**
     *
     *
     */
    public function guest_add_data()
    {
        if (\swdf::$app->request["post"]["target_id"] === "NULL")
        {
            $target_id = NULL;

            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) \swdf::$app->request["post"]["article_id"],
                    "operator" => "=",
                    "condition" => "AND",
                ),
                array(
                    "field" => "target_id",
                    "operator" => "IS NULL",
                    "condition" => "",
                ),
            );
            $record = $this->where($where)->order(array("`number` DESC"))->select_first()["record"];

            if ($record === FALSE)
            {
                $number = 1;
            }
            else
            {
                $number = (int) $record["number"] + 1;
            }
        }
        else
        {
            $target_id = (int) \swdf::$app->request["post"]["target_id"];
            $number = NULL;
        }

        $data_comment = array(
            "date"          => date("Y-m-d H:i:s"),
            "number"        => $number,

            "user"          => \swdf::$app->request["post"]["user"],
            "mail"          => \swdf::$app->request["post"]["mail"],
            "site"          => \swdf::$app->request["post"]["site"],
            "content"       => \swdf::$app->request["post"]["content"],

            "target_id"     => $target_id,
            "article_id"    => (int) \swdf::$app->request["post"]["article_id"],
        );

        $ret = $this->add($data_comment);

        $this->get_by_id($ret["last_id"]);
    }




    /**
     *
     *
     */
    public function validate_add()
    {
        if (
            (isset(\swdf::$app->request["post"]["form_stamp"]) === FALSE) ||
            (\swdf::$app->request["post"]["form_stamp"] !== \swdf::$app->data["user"]->record["form_stamp"])
        )
        {
            return array(
                "result" => FALSE,
                "message" => "XSRF."
            );
        }
        else
        {
            $ret = $this->validate();

            if ($ret["result"] === FALSE)
            {
                return $ret;
            }
            else
            {
                return array(
                    "result" => TRUE,
                );
            }
        }
    }


    /**
     *
     *
     */
    public function add_data()
    {
        if (\swdf::$app->request["post"]["target_id"] === "NULL")
        {
            $target_id = NULL;

            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) \swdf::$app->request["post"]["article_id"],
                    "operator" => "=",
                    "condition" => "AND",
                ),
                array(
                    "field" => "target_id",
                    "operator" => "IS NULL",
                    "condition" => "",
                ),
            );
            $record = $this->where($where)->order(array("`number` DESC"))->select_first()["record"];

            if ($record === FALSE)
            {
                $number = 1;
            }
            else
            {
                $number = (int) $record["number"] + 1;
            }
        }
        else
        {
            $target_id = (int) \swdf::$app->request["post"]["target_id"];
            $number = NULL;
        }

        if (isset(\swdf::$app->request["post"]["author"]) === TRUE)
        {
            $author = TRUE;
        }
        else
        {
            $author = FALSE;
        }

        $data_comment = array(
            "date"          => date("Y-m-d H:i:s"),
            "number"        => $number,
            "user"          => \swdf::$app->request["post"]["user"],
            "mail"          => \swdf::$app->request["post"]["mail"],
            "site"          => \swdf::$app->request["post"]["site"],
            "content"       => \swdf::$app->request["post"]["content"],
            "author"        => $author,

            "target_id"     => $target_id,
            "article_id"    => (int) \swdf::$app->request["post"]["article_id"],
        );

        $ret = $this->add($data_comment);

        $this->get_by_id($ret["last_id"]);
    }



    /**
     *
     *
     */
    public function validate_delete()
    {
        $ret = \swdf::$app->data["user"]->validate_password(\swdf::$app->request["post"]["password"]);
        if ($ret["result"] === FALSE)
        {
            return $ret;
        }
        else
        {
            return array(
                "result" => TRUE,
            );
        }
    }




    /**
     *
     *
     */
    public function delete_data()
    {
        $this->delete_by_id($this->record["id"]);

        $where = array(
            array(
                "field" => "target_id",
                "value" => (int) \swdf::$app->request["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $records = $this->where($where)->select()["record"];

        $this->recursive_delete($records);

    }







    /**
     *
     *
     */
    private function validate()
    {
        $article = new article();

        //
        // No form_stamp check, because guest have no form_stamp.
        //

        if (
            (isset(\swdf::$app->request["post"]["article_id"])  === FALSE) ||
            (isset(\swdf::$app->request["post"]["target_id"])   === FALSE) ||
            (isset(\swdf::$app->request["post"]["user"])        === FALSE) ||
            (isset(\swdf::$app->request["post"]["mail"])        === FALSE) ||
            (isset(\swdf::$app->request["post"]["content"])     === FALSE)
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
                (\swdf::$app->request["post"]["article_id"] === "") ||
                (\swdf::$app->request["post"]["target_id"]  === "") ||
                (\swdf::$app->request["post"]["user"]       === "") ||
                (\swdf::$app->request["post"]["mail"]       === "") ||
                (\swdf::$app->request["post"]["content"]    === "")
            )
            {
                return array(
                    "result" => FALSE,
                    "message" => "Form uncomplete, one or more necessary field is empty."
                );
            }
            else
            {
                if (\swdf::$app->request["post"]["target_id"] === "NULL")
                {
                    if ($article->select_by_id(\swdf::$app->request["post"]["article_id"])["record"] === FALSE)
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
                        ($article->select_by_id(\swdf::$app->request["post"]["article_id"])["record"] === FALSE) ||
                        ($this->select_by_id(\swdf::$app->request["post"]["target_id"])["record"] === FALSE)
                    )
                    {
                        return array(
                            "result" => FALSE,
                            "message" => "Article id or target id not exists."
                        );
                    }
                    else
                    {
                        if ($this->select_by_id(\swdf::$app->request["post"]["target_id"])["record"]["article_id"] !== \swdf::$app->request["post"]["article_id"])
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
    private function recursive_delete($records)
    {
        foreach ($records as $comment)
        {
            $this->delete_by_id($comment["id"]);

            $where = array(
                array(
                    "field" => "target_id",
                    "value" => (int) $comment["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );

            $sub_records = $this->where($where)->order(array("`date` ASC"))->select()["record"];

            if (empty($sub_records) === FALSE)
            {
                $this->recursive_delete($sub_records);
            }
            else
            {
            }
        }
    }

}
?>
