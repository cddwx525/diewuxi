<?php
namespace blog\models;

use swdf\base\model;
use blog\models\article;

class category extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "category";
    }



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
    public function get_by_full_slug($full_slug)
    {
        $full_slug_data = $this->get_full_slug_data($full_slug);

        return $this->get_by_full_slug_data($full_slug_data);
    }


    /**
     *
     *
     */
    public function get_by_full_slug_data($full_slug_data)
    {
        foreach ($full_slug_data as $key => $slug)
        {
            if ($key === 0)
            {
                $where = array(
                    array(
                        "field" => "parent_id",
                        "operator" => "IS NULL",
                        "condition" => "AND",
                    ),
                    array(
                        "field" => "slug",
                        "value" => $slug,
                        "operator" => "=",
                        "condition" => "",
                    ),
                );
            }
            else
            {
                $where = array(
                    array(
                        "field" => "parent_id",
                        "value" => (int) $this->record["id"],
                        "operator" => "=",
                        "condition" => "AND",
                    ),
                    array(
                        "field" => "slug",
                        "value" => $slug,
                        "operator" => "=",
                        "condition" => "",
                    ),
                );
            }

            $this->record = $this->where($where)->select_first()["record"];
        }

        return $this;
    }


    /**
     *
     *
     */
    public function find_all()
    {
        $records = $this->select()["record"];

        $categories = array();
        foreach ($records as $key => $item)
        {
            $one_category = new category();
            $one_category->record = $item;
            $categories[$key] = $one_category;
        }

        return $categories;
    }


    /**
     *
     *
     */
    public function get_articles()
    {
        $article = new article();

        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $records = $article->where($where)->order(array("`date` DESC"))->select()["record"];


        $articles = array();
        foreach ($records as $key => $item)
        {
            $one_article = new article();
            $one_article->record = $item;
            $articles[$key] = $one_article;
        }

        return $articles;
    }


    /**
     *
     *
     */
    public function get_all_articles()
    {
        $article = new article();

        $categories = array();
        $categories[] = $this;
        $categories = array_merge($categories, $this->get_all_sub());


        // Get articles belonged to category.
        $where = array();
        $where[0] = "OR";
        foreach ($categories as $one_category)
        {
            $where[1][] = array(
                "field" => "category_id",
                "value" => (int) $one_category->record["id"],
                "operator" => "=",
            );
        }
        $records = $article->batch_where($where)->order(array("`date` DESC"))->select()["record"];


        $articles = array();
        foreach ($records as $key => $item)
        {
            $one_article = new article();
            $one_article->record = $item;
            $articles[$key] = $one_article;
        }

        return $articles;
    }


    /**
     * Get article_count.
     *
     */
    public function get_article_count()
    {
        $article = new article();

        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        return $article->where($where)->select_count()["record"];
    }


    ///**
    // * Category array tree.
    // *
    // */
    //public function get_tree()
    //{
    //    $where = array(
    //        array(
    //            "field" => "parent_id",
    //            "operator" => "IS NULL",
    //            "condition" => "",
    //        ),
    //    );
    //    $records = $this->where($where)->select()["record"];

    //    $top_categories = array();
    //    foreach ($records as $key => $item)
    //    {
    //        $one_category = new category();
    //        $one_category->record = $item;
    //        $top_categories[$key] = $one_category;
    //    }

    //    return $this->hierarchy($top_categories);
    //}


    /**
     *
     *
     */
    public function get_root()
    {
        $where = array(
            array(
                "field" => "parent_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $records = $this->where($where)->select()["record"];

        $root_categories = array();
        foreach ($records as $key => $item)
        {
            $one_category = new category();
            $one_category->record = $item;
            $root_categories[$key] = $one_category;
        }

        return $root_categories;
    }


    /**
     * @description Categories instances from this up to root.
     * @param None
     * @return array Categories instances array.
     */
    public function get_path()
    {
        $categories = array();

        $categories[] = $this;

        // New instance, do NOT affect this instance.
        $category = new category();
        $category->get_by_id($this->record["id"]);

        while ($category->record["parent_id"] !== NULL)
        {
            // Use return value to accept instance.
            $category = $category->get_by_id($category->record["parent_id"]);
            $categories[] = $category;
        }

        krsort($categories, SORT_NUMERIC);

        return $categories;
    }


    /**
     *
     *
     */
    public function get_parent()
    {
        if (is_null($this->record["parent_id"]) === TRUE)
        {
            return NULL;
        }
        else
        {
            // New instance, do NOT affect this instance.
            $category = new category();

            return $category->get_by_id($this->record["parent_id"]);
        }
    }


    /**
     * Sub category list of a category.
     *
     */
    public function get_sub()
    {
        $where = array(
            array(
                "field" => "parent_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $records = $this->where($where)->select()["record"];

        $categories = array();
        foreach ($records as $key => $item)
        {
            $one_category = new category();
            $one_category->record = $item;
            $categories[$key] = $one_category;
        }

        return $categories;
    }


    /**
     * All sub category list of a category.
     *
     */
    public function get_all_sub()
    {
        return $this->recusive_all_sub($this);
    }


    /**
     *
     *
     */
    public function get_sub_count()
    {
        $where = array(
            array(
                "field" => "parent_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        return $this->where($where)->select_count()["record"];
    }


    /**
     *
     *
     */
    public function get_full_slug()
    {
        $slugs = array();
        $slugs[] = $this->record["slug"];

        // New instance to get slug list, do NOT affect this instance.
        $category = new category();
        $category->get_by_id($this->record["id"]);

        while ($category->record["parent_id"] !== NULL)
        {
            $category->get_by_id($category->record["parent_id"]);

            $slugs[] = $category->record["slug"];
        }

        krsort($slugs, SORT_NUMERIC);

        return $this->get_full_slug_by_data($slugs);
    }


    /**
     *
     *
     */
    public function get_full_name()
    {
        $names = array();
        $names[] = $this->record["name"];

        // New instance to get name list, do NOT affect this instance.
        $category = new category();
        $category->get_by_id($this->record["id"]);

        while ($category->record["parent_id"] !== NULL)
        {
            $category->get_by_id($category->record["parent_id"]);

            $names[] = $category->record["name"];
        }

        krsort($names, SORT_NUMERIC);

        return "/" . implode("/", $names);
    }





    /**
     *
     *
     */
    public function get_full_slug_data($full_slug)
    {
        //$return array_slice(explode("/", $full_slug), 0, -1);
        return explode("/", $full_slug);
    }





    /**
     *
     *
     */
    public function get_full_slug_by_data($full_slug_data)
    {
        //$return array_slice(explode("/", $full_slug), 0, -1);
        return implode("/", $full_slug_data);
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
    public function get_is_full_slug($full_slug)
    {
        $full_slug_data = $this->get_full_slug_data($full_slug);

        return $this->get_is_full_slug_data($full_slug_data);
    }




    /**
     *
     *
     */
    public function get_is_full_slug_data($full_slug_data)
    {
        foreach ($full_slug_data as $key => $slug)
        {
            if ($key === 0)
            {
                $where = array(
                    array(
                        "field" => "parent_id",
                        "operator" => "IS NULL",
                        "condition" => "AND",
                    ),
                    array(
                        "field" => "slug",
                        "value" => $slug,
                        "operator" => "=",
                        "condition" => "",
                    ),
                );
            }
            else
            {
                $where = array(
                    array(
                        "field" => "parent_id",
                        "value" => (int) $record["id"],
                        "operator" => "=",
                        "condition" => "AND",
                    ),
                    array(
                        "field" => "slug",
                        "value" => $slug,
                        "operator" => "=",
                        "condition" => "",
                    ),
                );
            }

            $record = $this->where($where)->select_first()["record"];

            if ($record === FALSE)
            {
                // Category for this slug not exists.

                return FALSE;
            }
            else
            {
            }
        }

        return TRUE;
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
            if ($this->get_is_full_slug(\swdf::$app->request["post"]["full_slug"]) === TRUE)
            {
                // Category conflict.

                return array(
                    "result" => FALSE,
                    "message" => "Slug conflict."
                );
            }
            else
            {
                // Category for this full slug not exists.

                $full_slug_data = $this->get_full_slug_data(\swdf::$app->request["post"]["full_slug"]);

                if (count($full_slug_data) > 1)
                {
                    // Multi level.

                    $parent_full_slug_data = array_slice($full_slug_data, 0, -1);

                    if ($this->get_is_full_slug_data($parent_full_slug_data) === FALSE)
                    {
                        return array(
                            "result" => FALSE,
                            "message" => "Parent category not exists."
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
                    // Root level.

                    return array(
                        "result" => TRUE,
                    );
                }
            }
        }
    }



    /**
     *
     *
     */
    public function add_data()
    {
        $full_slug_data = $this->get_full_slug_data(\swdf::$app->request["post"]["full_slug"]);

        if (count($full_slug_data) > 1)
        {
            $parent = new category();
            $parent->get_by_full_slug_data(array_slice($full_slug_data, 0, -1));

            $slug = array_slice($full_slug_data, -1)[0];

            $data_category = array(
                "name"          => \swdf::$app->request["post"]["name"],
                "slug"          => $slug,
                "description"   => \swdf::$app->request["post"]["description"],
                "parent_id"     => (int) $parent->record["id"],
            );
        }
        else
        {
            $data_category = array(
                "name"          => \swdf::$app->request["post"]["name"],
                "slug"          => $full_slug_data[0],
                "description"   => \swdf::$app->request["post"]["description"],
                "parent_id"     => NULL,
            );
        }

        $ret = $this->add($data_category);

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
            if ($this->get_is_full_slug(\swdf::$app->request["post"]["full_slug"]) === TRUE)
            {
                // Category for this full slug exists.

                $category = new category();
                $category->get_by_full_slug(\swdf::$app->request["post"]["full_slug"]);

                if ((int) $category->record["id"] !== (int) \swdf::$app->request["post"]["id"])
                {
                    // Category slug conflict..

                    return array(
                        "result" => FALSE,
                        "message" => "Slug conflict."
                    );
                }
                else
                {
                    // Slug not changed.

                    return array(
                        "result" => TRUE,
                    );
                }
            }
            else
            {
                // Category for this full slug not exists.

                $full_slug_data = $this->get_full_slug_data(\swdf::$app->request["post"]["full_slug"]);

                if (count($full_slug_data) > 1)
                {
                    // Multi level.

                    $parent_full_slug_data = array_slice($full_slug_data, 0, -1);

                    if ($this->get_is_full_slug_data($parent_full_slug_data) === FALSE)
                    {
                        // Parent category for this slug not exists.

                        return array(
                            "result" => FALSE,
                            "message" => "Parent category not exists."
                        );
                    }
                    else
                    {
                        // Parent category for this slug exists.

                        return array(
                            "result" => TRUE,
                        );
                    }
                }
                else
                {
                    // Root level.

                    return array(
                        "result" => TRUE,
                    );
                }
            }
        }
    }




    /**
     *
     *
     */
    public function update_data()
    {
        $full_slug_data = $this->get_full_slug_data(\swdf::$app->request["post"]["full_slug"]);

        if (count($full_slug_data) > 1)
        {
            $parent_category = new category();
            $parent_category->get_by_full_slug_data(array_slice($full_slug_data, 0, -1));

            $slug = array_slice($full_slug_data, -1)[0];

            $data_category = array(
                "name"          => \swdf::$app->request["post"]["name"],
                "slug"          => $slug,
                "description"   => \swdf::$app->request["post"]["description"],
                "parent_id"     => (int) $parent_category->record["id"],
            );
        }
        else
        {
            $data_category = array(
                "name"          => \swdf::$app->request["post"]["name"],
                "slug"          => $full_slug_data[0],
                "description"   => \swdf::$app->request["post"]["description"],
                "parent_id"     => NULL,
            );
        }

        $this->update_by_id($this->record["id"], $data_category);

        return $this->get_by_id($this->record["id"]);
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
                ((int) $this->get_sub_count() !== 0) ||
                ((int) $this->get_article_count() !== 0)
            )
            {
                return array(
                    "result" => FALSE,
                    "message" => "Has sub category or article."
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







    ///**
    // *
    // *
    // */
    //private function hierarchy($categories)
    //{
    //    foreach ($categories as $key => $category)
    //    {
    //        $categories[$key] = $this->get_category($category);

    //        // Get sub categories.
    //        $subcategories = $this->get_sub($category);

    //        if (! empty($subcategories))
    //        {
    //            $categories[$key]["son"] = $this->hierarchy($subcategories);
    //        }
    //        else
    //        {
    //            $categories[$key]["son"] = NULL;
    //        }
    //    }

    //    return $categories;
    //}




    /**
     *
     *
     */
    private function recusive_all_sub($category)
    {
        $sub_categories = $category->get_sub();

        $all_sub_categories = array();

        if (empty($sub_categories) === FALSE)
        {
            foreach ($sub_categories as $one_category)
            {
                $all_sub_categories[] = $one_category;
                $all_sub_categories = array_merge($all_sub_categories, $this->recusive_all_sub($one_category));
            }
        }
        else
        {
        }

        return $all_sub_categories;
    }


    /**
     *
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
                (isset(\swdf::$app->request["post"]["name"])        === FALSE) ||
                (isset(\swdf::$app->request["post"]["full_slug"])   === FALSE)
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
                    (\swdf::$app->request["post"]["name"]       === "") ||
                    (\swdf::$app->request["post"]["full_slug"]  === "")
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
