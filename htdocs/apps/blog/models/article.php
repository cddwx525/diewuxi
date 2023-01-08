<?php
namespace blog\models;

use swdf\base\model;
use blog\models\category;
use blog\models\tag;
use blog\models\article_tag;
use blog\models\article_file;
use blog\models\comment;
use blog\models\file;

class article extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "article";
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
        $category = new category();

        $full_slug_data = $this->get_full_slug_data($full_slug);
        $full_category_slug_list = $full_slug_data[0];
        $article_slug = $full_slug_data[1];

        $category->get_by_full_slug($category->get_full_slug_by_data($full_category_slug_list));

        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $category->record["id"],
                "operator" => "=",
                "condition" => "AND",
            ),
            array(
                "field" => "slug",
                "value" => $article_slug,
                "operator" => "=",
                "condition" => "",
            ),
        );
        $this->record = $this->where($where)->select_first()["record"];

        return $this;
    }


    /**
     *
     *
     */
    public function find_all()
    {
        $records = $this->order(array("`date` DESC"))->select()["record"];

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
    public function get_latest($number)
    {
        $records = $this->order(array("`date` DESC"))->limit(0, $number)->select()["record"];

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
    public function get_category()
    {
        $category = new category();

        return  $category->get_by_id($this->record["category_id"]);
    }


    /**
     *
     *
     */
    public function get_tags()
    {
        $article_tag = new article_tag();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $records = $article_tag->where($where)->select()["record"];

        $tags = array();
        foreach ($records as $key => $item)
        {
            $one_tag = new tag();
            $tags[$key] = $one_tag->get_by_id($item["tag_id"]);
        }

        return $tags;
    }


    /**
     *
     *
     */
    public function get_tag_slugs()
    {
        return implode(", ", $this->get_tag_slug_list());
    }



    /**
     *
     *
     */
    public function get_tag_slug_list()
    {
        $tag_slug_list = array();
        foreach ($this->get_tags() as $key => $item)
        {
            $tag_slug_list[] = $item->record["slug"];
        }

        return $tag_slug_list;
    }


    /**
     *
     *
     */
    public function get_full_slug()
    {
        $category = new category();

        $slug_list = array();

        $slug_list[] = $this->record["slug"];

        $category->get_by_id($this->record["category_id"]);
        $slug_list[] = $category->record["slug"];

        while ($category->record["parent_id"] !== NULL)
        {
            $category->get_by_id($category->record["parent_id"]);

            $slug_list[] = $category->record["slug"];
        }

        krsort($slug_list, SORT_NUMERIC);

        return implode("/", $slug_list);
    }




    /**
     *
     *
     */
    public function get_full_slug_data($full_slug)
    {
        return array(
            array_slice(explode("/", $full_slug), 0, -1),
            array_slice(explode("/", $full_slug), -1)[0],
        );
    }



    /**
     *
     *
     */
    public function get_comments()
    {
        $comment = new comment();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $records = $comment->where($where)->select()["record"];

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
    public function get_root_comments()
    {
        $comment = new comment();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "AND",
            ),
            array(
                "field" => "target_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $records = $comment->where($where)->order(array("`number` ASC"))->select()["record"];

        $root_comments = array();
        foreach ($records as $key => $item)
        {
            $one_comment = new comment();
            $one_comment->record = $item;
            $root_comments[$key] = $one_comment;
        }

        return $root_comments;
    }


    /**
     *
     *
     */
    public function get_comment_count()
    {
        $comment = new comment();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "AND",
            ),
            array(
                "field" => "target_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );

        return $comment->where($where)->select_count()["record"];
    }


    /**
     *
     *
     */
    public function get_files()
    {
        $article_file = new article_file();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $records = $article_file->where($where)->select()["record"];

        $files = array();
        foreach ($records as $key => $item)
        {
            $file = new file();
            $files[$key] = $file->get_by_id($item["file_id"]);
        }

        return $files;
    }


    /**
     *
     *
     */
    public function get_file_count()
    {
        $article_file = new article_file();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        return $article_file->where($where)->select_count()["record"];
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
        $category = new category();

        $full_slug_data = $this->get_full_slug_data($full_slug);

        $full_category_slug_list = $full_slug_data[0];
        $article_slug = $full_slug_data[1];

        if ($category->get_is_full_slug($category->get_full_slug_by_data($full_category_slug_list)) === TRUE)
        {
            // Category full sulg exists.

            $category->get_by_full_slug($category->get_full_slug_by_data($full_category_slug_list));

            $where = array(
                array(
                    "field" => "category_id",
                    "value" => (int) $category->record["id"],
                    "operator" => "=",
                    "condition" => "AND",
                ),
                array(
                    "field" => "slug",
                    "value" => $article_slug,
                    "operator" => "=",
                    "condition" => "",
                ),
            );

            if ($this->where($where)->select_first()["record"] === FALSE)
            {
                // Article slug NOT exists.

                return FALSE;
            }
            else
            {
                // Article slug exists.

                return TRUE;
            }
        }
        else
        {
            // Category full sulg NOT exists.

            return FALSE;
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
            $category = new category();
            if ($category->get_is_full_slug(\swdf::$app->request["post"]["category_full_slug"]) === FALSE)
            {
                // Category NOT exists.

                return array(
                    "result" => FALSE,
                    "message" => "Category not exists."
                );
            }
            else
            {
                // Category exists.

                $category->get_by_full_slug(\swdf::$app->request["post"]["category_full_slug"]);

                $where = array(
                    array(
                        "field" => "category_id",
                        "value" => (int) $category->record["id"],
                        "operator" => "=",
                        "condition" => "AND",
                    ),
                    array(
                        "field" => "slug",
                        "value" => \swdf::$app->request["post"]["slug"],
                        "operator" => "=",
                        "condition" => "",
                    ),
                );

                if ($this->where($where)->select_first()["record"] === FALSE)
                {
                    // Slug not used.

                    return array(
                        "result" => TRUE,
                    );
                }
                else
                {
                    // Slug conflict.

                    return array(
                        "result" => FALSE,
                        "message" => "Slug conflict."
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
        $category = $this->save_category(\swdf::$app->request["post"]["category_full_slug"]);

        $data_article = array(
            "slug"          => \swdf::$app->request["post"]["slug"],
            "date"          => \swdf::$app->request["post"]["date"],
            "title"         => \swdf::$app->request["post"]["title"],
            "content"       => \swdf::$app->request["post"]["content"],
            "keywords"      => \swdf::$app->request["post"]["keywords"],
            "description"   => \swdf::$app->request["post"]["description"],
            "category_id"   => (int) $category->record["id"],
        );
        $ret = $this->add($data_article);

        $this->get_by_id($ret["last_id"]);

        $this->add_article_tag(\swdf::$app->request["post"]["tag_slugs"]);
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
            $category = new category();
            if ($category->get_is_full_slug(\swdf::$app->request["post"]["category_full_slug"]) === FALSE)
            {
                // Category NOT exists.

                return array(
                    "result" => FALSE,
                    "message" => "Category not exists."
                );
            }
            else
            {
                // Category exists.

                $category->get_by_full_slug(\swdf::$app->request["post"]["category_full_slug"]);

                $where = array(
                    array(
                        "field" => "category_id",
                        "value" => (int) $category->record["id"],
                        "operator" => "=",
                        "condition" => "AND",
                    ),
                    array(
                        "field" => "slug",
                        "value" => \swdf::$app->request["post"]["slug"],
                        "operator" => "=",
                        "condition" => "",
                    ),
                );

                $record = $this->where($where)->select_first()["record"];

                if ($record === FALSE)
                {
                    // Slug not used.

                    return array(
                        "result" => TRUE,
                    );
                }
                else
                {
                    // Slug exists.

                    if ((int) $record["id"] !== (int) \swdf::$app->request["post"]["id"])
                    {
                        // Slug conflict.

                        return array(
                            "result" => FALSE,
                            "message" => "Slug conflict."
                        );
                    }
                    else
                    {
                        // Slug not changed..

                        return array(
                            "result" => TRUE,
                        );
                    }

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
        $category = $this->save_category(\swdf::$app->request["post"]["category_full_slug"]);

        $data_article = array(
            "slug"          => \swdf::$app->request["post"]["slug"],
            "date"          => \swdf::$app->request["post"]["date"],
            "title"         => \swdf::$app->request["post"]["title"],
            "content"       => \swdf::$app->request["post"]["content"],
            "keywords"      => \swdf::$app->request["post"]["keywords"],
            "description"   => \swdf::$app->request["post"]["description"],
            "category_id"   => (int) $category->record["id"],
        );

        $this->update_by_id($this->record["id"], $data_article);

        $this->update_article_tag(\swdf::$app->request["post"]["tag_slugs"]);

        $this->get_by_id($this->record["id"]);
    }



    /**
     *
     *
     */
    public function validate_delete()
    {
        return $this->validate();
    }


    /**
     *
     *
     */
    public function delete_data()
    {
        $article_tag = new article_tag();
        $article_file = new article_file();
        $comment = new comment();

        $this->delete_by_id(\swdf::$app->request["post"]["id"]);

        // Delete article tag relation.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) \swdf::$app->request["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag->where($where)->delete();

        // Delete article file relation.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) \swdf::$app->request["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_file->where($where)->delete();


        // Delete comments.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) \swdf::$app->request["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $comment->where($where)->delete();
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
                (isset(\swdf::$app->request["post"]["date"])                === FALSE) ||
                (isset(\swdf::$app->request["post"]["title"])               === FALSE) ||
                (isset(\swdf::$app->request["post"]["slug"])                === FALSE) ||
                (isset(\swdf::$app->request["post"]["content"])             === FALSE) ||
                (isset(\swdf::$app->request["post"]["keywords"])            === FALSE) ||
                (isset(\swdf::$app->request["post"]["description"])         === FALSE) ||
                (isset(\swdf::$app->request["post"]["category_full_slug"])  === FALSE) ||
                (isset(\swdf::$app->request["post"]["tag_slugs"])           === FALSE)
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
                    (\swdf::$app->request["post"]["date"]               === "") ||
                    (\swdf::$app->request["post"]["title"]              === "") ||
                    (\swdf::$app->request["post"]["slug"]               === "") ||
                    (\swdf::$app->request["post"]["content"]            === "") ||
                    (\swdf::$app->request["post"]["keywords"]           === "") ||
                    (\swdf::$app->request["post"]["description"]        === "") ||
                    (\swdf::$app->request["post"]["category_full_slug"] === "") ||
                    (\swdf::$app->request["post"]["tag_slugs"]          === "")
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


    /**
     *
     *
     */
    private function save_category($category_full_slug)
    {
        $category = new category();

        return $category->get_by_full_slug($category_full_slug);

        //if ($category->get_is_full_slug($category_full_slug) === TRUE)
        //{
        //    // Category for this full slug exists.

        //    return $category->get_by_full_slug($category_full_slug);
        //}
        //else
        //{
        //    // Category for this full slug not exists. Add them recursively.

        //    // TODO check full_slug format
        //    $original_full_slug_data = $category->get_full_slug_data($category_full_slug);

        //    $flag = FALSE;
        //    foreach ($original_full_slug_data as $key => $slug)
        //    {
        //        // Get full slug of every level.
        //        // a/b/c/d
        //        //     a
        //        //     a/b
        //        //     a/b/c
        //        //     a/b/c/d
        //        $full_slug_data = array_slice($original_full_slug_data, 0, ($key - 0) + 1);

        //        if (
        //            ($flag === TRUE) ||
        //            ($category->get_is_full_slug_data($full_slug_data) === FALSE)
        //        )
        //        {
        //            // This level of full slug not exists, add category.

        //            $flag = TRUE;       // Set flag, sub category all need created.

        //            if ($key === 0)
        //            {
        //                $data_category = array(
        //                    "name"          => $slug,
        //                    "slug"          => $slug,
        //                    "description"   => "",
        //                    "parent_id"     => NULL,
        //                );
        //            }
        //            else
        //            {
        //                $data_category = array(
        //                    "name"          => $slug,
        //                    "slug"          => $slug,
        //                    "description"   => "",
        //                    "parent_id"     => $category->record["id"],
        //                );
        //            }

        //            $ret = $category->add($data_category);
        //            $category->get_by_id($ret["last_id"]);
        //        }
        //        else
        //        {
        //            // This level of full slug exists.

        //            $category->get_by_full_slug_data($full_slug_data);
        //        }
        //    }

        //    return $category;
        //}
    }



    /**
     *
     *
     */
    private function add_article_tag($tag_slugs)
    {
        $tag = new tag();
        $article_tag = new article_tag();

        // TODO tag format check
        $tag_slug_list = explode(", ", $tag_slugs);

        foreach ($tag_slug_list as $tag_slug)
        {
            $where = array(
                array(
                    "field" => "slug",
                    "value" => $tag_slug,
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $record = $tag->where($where)->select_first()["record"];

            if ($record === FALSE)
            {
                // Tag not exist, add.

                $data_tag = array(
                    "name"          => $tag_slug,
                    "slug"          => $tag_slug,
                    "description"   => "",
                );
                $ret = $tag->add($data_tag);

                $data_article_tag = array(
                    "article_id"    => (int) $this->record["id"],
                    "tag_id"        => (int) $ret["last_id"],
                );
                $article_tag->add($data_article_tag);
            }
            else
            {
                // Tag exists.

                $data_article_tag = array(
                    "article_id"    => (int) $this->record["id"],
                    "tag_id"        => (int) $record["id"],
                );
                $article_tag->add($data_article_tag);
            }
        }
    }


    /**
     *
     *
     */
    private function update_article_tag($tag_slugs)
    {
        $tag = new tag();
        $article_tag = new article_tag();

        $old_tag_slug_list = $this->get_tag_slug_list();

        // TODO tag format check
        $tag_slug_list = explode(", ", $tag_slugs);

        // Add new tag.
        foreach (array_diff($tag_slug_list, $old_tag_slug_list) as $tag_slug)
        {
            $where = array(
                array(
                    "field" => "slug",
                    "value" => $tag_slug,
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $record = $tag->where($where)->select_first()["record"];

            if ($record === FALSE)
            {
                // New tag.

                $data_tag = array(
                    "name"          => $tag_slug,
                    "slug"          => $tag_slug,
                    "description"   => "",
                );
                $ret = $tag->add($data_tag);

                // Add article tag relation.
                $data_article_tag = array(
                    "article_id"    => (int) $this->record["id"],
                    "tag_id"        => (int) $ret["last_id"],
                );
                $article_tag->add($data_article_tag);
            }
            else
            {
                // The tag exists, add article tag relation.

                $data_article_tag = array(
                    "article_id"    => (int) $this->record["id"],
                    "tag_id"        => (int) $record["id"],
                );
                $article_tag->add($data_article_tag);
            }
        }

        // Delete unused tag.
        foreach (array_diff($old_tag_slug_list, $tag_slug_list) as $tag_slug)
        {
            $where = array(
                array(
                    "field" => "slug",
                    "value" => $tag_slug,
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $record = $tag->where($where)->select_first()["record"];

            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $this->record["id"],
                    "operator" => "=",
                    "condition" => "AND",
                ),
                array(
                    "field" => "tag_id",
                    "value" => (int) $record["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article_tag->where($where)->delete();
        }
    }


}
?>
