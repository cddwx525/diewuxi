<?php
namespace blog\models;

use swdf\base\model;
use blog\models\article;
use blog\models\article_tag;

class tag extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "tag";
    }


        //$tag["article_count"] = $this->get_article_count($tag);


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
    public function get_by_slug($slug)
    {
        $where = array(
            array(
                "field" => "slug",
                "value" => $slug,
                "operator" => "=",
                "condition" => "",
            ),
        );

        $this->record = $this->where($where)->select_first()["record"];

        return $this;
    }


    /**
     * @description Get all instances.
     * @param None
     * @return array Array of instances.
     */
    public function find_all()
    {
        $records = $this->select()["record"];

        $tags = array();
        foreach ($records as $key => $item)
        {
            $one_tag = new tag();
            $one_tag->record = $item;
            $tags[$key] = $one_tag;
        }

        return $tags;
    }


    /**
     *
     *
     */
    public function get_articles()
    {
        $article_tag = new article_tag();

        $where = array(
            array(
                "field" => "tag_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $records = $article_tag->where($where)->select()["record"];

        $articles = array();
        foreach ($records as $key => $item)
        {
            $one_article = new article();
            $articles[$key] = $one_article->get_by_id($item["article_id"]);
        }

        return $articles;
    }


    /**
     * @description Get number of articles belong to this tag.
     * @param None
     * @return int Number of articles.
     */
    public function get_article_count()
    {
        $article_tag = new article_tag();

        $where = array(
            array(
                "field" => "tag_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        return $article_tag->where($where)->select_count()["record"];
    }


    /**
     *
     *
     */
    public function get_is_slug($slug)
    {
        $where = array(
            array(
                "field" => "slug",
                "value" => $slug,
                "operator" => "=",
                "condition" => "",
            ),
        );

        if ($this->where($where)->select_first()["record"] === FALSE)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
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
    public function validate_add()
    {
        $ret = $this->validate();

        if ($ret["result"] === FALSE)
        {
            return $ret;
        }
        else
        {
            if ($this->get_is_slug(\swdf::$app->request["post"]["slug"]) === TRUE)
            {
                // Tag slug conflict.

                return array(
                    "result" => FALSE,
                    "message" => "Slug conflict."
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




    /**
     *
     *
     */
    public function add_data()
    {
        $data_tag = array(
            "name"          => \swdf::$app->request["post"]["name"],
            "slug"          => \swdf::$app->request["post"]["slug"],
            "description"   => \swdf::$app->request["post"]["description"],
        );

        $ret = $this->add($data_tag);

        $this->get_by_id($ret["last_id"]);
    }




    /**
     *
     *
     */
    public function validate_update()
    {
        $ret = $this->validate();

        if ($ret["result"] === FALSE)
        {
            return $ret;
        }
        else
        {
            if ($this->get_is_slug(\swdf::$app->request["post"]["slug"]) === TRUE)
            {
                // Slug exists.

                $tag = new tag();
                $tag->get_by_slug(\swdf::$app->request["post"]["slug"]);

                if ((int) $tag->record["id"] !== (int) \swdf::$app->request["post"]["id"])
                {
                    // Slug conflict..

                    return array(
                        "result" => FALSE,
                        "message" => "Slug conflict."
                    );
                }
                else
                {
                    // Slug not change.

                    return array(
                        "result" => TRUE,
                    );
                }
            }
            else
            {
                // Slug not exists.

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
    public function update_data()
    {
        $data_tag = array(
            "name"          => \swdf::$app->request["post"]["name"],
            "slug"          => \swdf::$app->request["post"]["slug"],
            "description"   => \swdf::$app->request["post"]["description"],
        );

        $this->update_by_id($this->record["id"], $data_tag);

        $this->get_by_id($this->record["id"]);
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
            if (
                ((int) $this->get_article_count() !== 0)
            )
            {
                return array(
                    "result" => FALSE,
                    "message" => "Has article."
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




    /**
     *
     *
     */
    public function delete_data()
    {
        return $this->delete_by_id($this->record["id"]);
    }





    /**
     *
     * TODO: slug check, "[[:word:]-]+".
     *
     */
    private function validate()
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
            if (
                (isset(\swdf::$app->request["post"]["name"]) === FALSE) ||
                (isset(\swdf::$app->request["post"]["slug"]) === FALSE)
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
                    (\swdf::$app->request["post"]["name"] === "") ||
                    (\swdf::$app->request["post"]["slug"] === "")
                )
                {
                    return array(
                        "result" => FALSE,
                        "message" => "Form uncomplete, one or more necessary field is empty."
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
?>
