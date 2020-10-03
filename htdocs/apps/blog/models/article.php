<?php
namespace blog\models;

use swdf\base\model;
use blog\models\category;
use blog\models\tag;
use blog\models\article_tag;
use blog\models\comment;

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
    public function get_article($article)
    {
        $article["full_slug"] = $this->get_full_slug($article);
        $article["category"] = $this->get_category($article);
        $article["tags"] = $this->get_tags($article);
        $article["tag_slugs"] = $this->get_tag_slugs($article);
        $article["comment_tree"] = $this->get_comment_tree($article);
        $article["comment_count"] = $this->get_comment_count($article);
        $article["file_count"] = $this->get_file_count($article);

        return $article;
    }


    /**
     *
     *
     */
    public function get_by_id($id)
    {
        return $this->get_article($this->select_by_id($id)["record"]);
    }




    /**
     *
     *
     */
    public function get_by_full_slug($full_slug)
    {
        $category_model = new category();

        $full_slug_data = $this->get_full_slug_data($full_slug);
        $full_category_slug_list = $full_slug_data[0];
        $article_slug = $full_slug_data[1];

        $category = $category_model->get_by_full_slug($category_model->get_full_slug_by_data($full_category_slug_list));

        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $category["id"],
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
        $article = $this->where($where)->select_first()["record"];

        return $this->get_article($article);
    }


    /**
     *
     *
     */
    public function get_articles()
    {
        $articles = $this->order(array("`date` DESC"))->select()["record"];

        foreach ($articles as $key => $article)
        {
            $articles[$key] = $this->get_article($article);
        }

        return $articles;
    }


    /**
     *
     *
     */
    public function get_category($article)
    {
        $category_model = new category();

        $category = $category_model->select_by_id((int) $article["category_id"])["record"];

        return $category_model->get_category($category);
    }


    /**
     *
     *
     */
    public function get_tags($article)
    {
        $tag_model = new tag();
        $article_tag_model = new article_tag();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $article["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_records = $article_tag_model->where($where)->select()["record"];

        $tags = array();
        foreach ($article_tag_records as $key => $article_tag_record)
        {
            $tag = $tag_model->select_by_id((int) $article_tag_record["tag_id"])["record"];
            $tags[$key] = $tag_model->get_tag($tag);
        }

        return $tags;
    }


    /**
     *
     *
     */
    public function get_tag_slugs($article)
    {
        $result = implode(", ", array_column($this->get_tags($article), "slug"));

        return $result;
    }


    /**
     *
     *
     */
    public function get_full_slug($article)
    {
        $category_model = new category();

        $slug_list = array();
        $slug_list[] = $article["slug"];

        $category = $category_model->select_by_id((int) $article["category_id"])["record"];

        $slug_list[] = $category["slug"];

        while ($category["parent_id"] != NULL)
        {
            $category = $category_model->select_by_id((int) $category["parent_id"])["record"];

            $slug_list[] = $category["slug"];
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
    public function get_comment_tree($article)
    {
        $comment_model = new comment();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $article["id"],
                "operator" => "=",
                "condition" => "AND",
            ),
            array(
                "field" => "target_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $top_comments = $comment_model->where($where)->order(array("`number` ASC"))->select()["record"];

        return $comment_model->hierarchy($top_comments);
    }


    /**
     *
     *
     */
    public function get_comment_count($article)
    {
        $comment_model = new comment();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $article["id"],
                "operator" => "=",
                "condition" => "AND",
            ),
            array(
                "field" => "target_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );

        return $comment_model->where($where)->select_count()["record"];
    }


    /**
     *
     *
     */
    public function get_file_count($article)
    {
        return "TODO";
    }


    /**
     *
     *
     */
    public function get_is_id($id)
    {
        if (
            (! isset($id))
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
                    ($this->select_by_id((int) $id)["record"] === FALSE)
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
        $category_model = new category();

        $full_slug_data = $this->get_full_slug_data($full_slug);
        $full_category_slug_list = $full_slug_data[0];
        $article_slug = $full_slug_data[1];

        // Filter wrong category slug.
        if ($category_model->get_is_full_slug($category_model->get_full_slug_by_data($full_category_slug_list)) === TRUE)
        {
            $category = $category_model->get_by_full_slug($category_model->get_full_slug_by_data($full_category_slug_list));

            $where = array(
                array(
                    "field" => "category_id",
                    "value" => (int) $category["id"],
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
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            return FALSE;
        }
    }


    /**
     *
     *
     */
    public function validate($data, $user)
    {
        $category_model = new category();

        if (
            (! isset($data["form_stamp"])) ||
            ($data["form_stamp"] != $user["form_stamp"])
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
                (! isset($data["date"])) ||
                (! isset($data["title"])) ||
                (! isset($data["slug"])) ||
                (! isset($data["content"])) ||
                (! isset($data["keywords"])) ||
                (! isset($data["description"])) ||
                (! isset($data["category_full_slug"])) ||
                (! isset($data["tag_slugs"]))
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
                    ($data["date"] === "") ||
                    ($data["title"] === "") ||
                    ($data["slug"] === "") ||
                    ($data["content"] === "") ||
                    ($data["keywords"] === "") ||
                    ($data["description"] === "") ||
                    ($data["category_full_slug"] === "") ||
                    ($data["tag_slugs"] === "")
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
    public function save_category($category_full_slug)
    {
        $category_model = new category();

        if ($category_model->get_is_full_slug($category_full_slug))
        {
            $category = $category_model->get_by_full_slug($category_full_slug);
        }
        else
        {
            // TODO check full_slug format
            $original_full_slug_data = $category_model->get_full_slug_data($category_full_slug);
            $flag = FALSE;
            foreach ($original_full_slug_data as $key => $slug)
            {
                $full_slug_data = array_slice($original_full_slug_data, 0, ($key - 0) + 1);

                if ($flag || (! $category_model->get_is_full_slug_data($full_slug_data)))
                {
                    $flag = TRUE;

                    if ($key === 0)
                    {
                        $data_category = array(
                            "name"          => $slug,
                            "slug"          => $slug,
                            "description"   => "",
                            "parent_id"     => NULL,
                        );
                    }
                    else
                    {
                        $data_category = array(
                            "name"          => $slug,
                            "slug"          => $slug,
                            "description"   => "",
                            "parent_id"     => $category["id"],
                        );
                    }
                    $result = $category_model->add_data($data_category);
                    $category = $category_model->get_by_id($result["last_id"]);
                }
                else
                {
                    $category = $category_model->get_by_full_slug_data($full_slug_data);
                }
            }
        }

        return $category;
    }


    /**
     *
     *
     */
    public function add_article_tag($article_id, $tag_slugs)
    {
        $tag_model = new tag();
        $article_tag_model = new article_tag();

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
            $tag = $tag_model->where($where)->select_first()["record"];

            if (! $tag)
            {
                // Tag not exist, add.
                $data_tag = array(
                    "name"          => $tag_slug,
                    "slug"          => $tag_slug,
                    "description"   => "",
                );
                $tag_add = $tag_model->add_data($data_tag);

                // Add article tag relation.
                $data_article_tag = array(
                    "article_id"    => (int) $article_id,
                    "tag_id"        => (int) $tag_add["last_id"],
                );
                $article_tag_add = $article_tag_model->add($data_article_tag);
            }
            else
            {
                // Tag exists.

                // Add article tag relation data.
                $data_article_tag = array(
                    "article_id"    => (int) $article_id,
                    "tag_id"        => (int) $tag["id"],
                );
                $article_tag_add = $article_tag_model->add($data_article_tag);
            }
        }
    }


    /**
     *
     *
     */
    public function update_article_tag($article_id, $tag_slugs)
    {
        $tag_model = new tag();
        $article_tag_model = new article_tag();

        $tags = $this->get_tags($this->get_by_id($article_id));
        $old_tag_slug_list = array_column($tags, "slug");

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
            $tag = $tag_model->where($where)->select_first()["record"];

            if (! $tag)
            {
                // New tag.

                $data_tag = array(
                    "name"          => $tag_slug,
                    "slug"          => $tag_slug,
                    "description"   => "",
                );
                $tag_add = $tag_model->add_data($data_tag);

                // Add article tag relation.
                $data_article_tag = array(
                    "article_id"    => (int) $article_id,
                    "tag_id"        => (int) $tag_add["last_id"],
                );
                $article_tag_add = $article_tag_model->add($data_article_tag);
            }
            else
            {
                // The tag exists, add article tag relation.
                $data_article_tag = array(
                    "article_id"    => (int) $article_id,
                    "tag_id"        => (int) $tag["id"],
                );
                $article_tag_add = $article_tag_model->add($data_article_tag);
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
            $tag = $tag_model->where($where)->select_first()["record"];

            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article_id,
                    "operator" => "=",
                    "condition" => "AND",
                ),
                array(
                    "field" => "tag_id",
                    "value" => (int) $tag["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article_tag_delete = $article_tag_model->where($where)->delete();
        }
    }


    /**
     *
     *
     */
    public function add_data($data)
    {
        $category = $this->save_category($data["category_full_slug"]);

        $data_article = array(
            "slug"          => $data["slug"],
            "date"          => $data["date"],
            "title"         => $data["title"],
            "content"       => $data["content"],
            "keywords"      => $data["keywords"],
            "description"   => $data["description"],
            "category_id"   => (int) $category["id"],
        );

        $article_add = $this->add($data_article);

        $this->add_article_tag($article_add["last_id"], $data["tag_slugs"]);

        return $article_add;
    }


    /**
     *
     *
     */
    public function update_data($data)
    {
        $category = $this->save_category($data["category_full_slug"]);

        $data_article = array(
            "slug"          => $data["slug"],
            "date"          => $data["date"],
            "title"         => $data["title"],
            "content"       => $data["content"],
            "keywords"      => $data["keywords"],
            "description"   => $data["description"],
            "category_id"   => (int) $category["id"],
        );

        $article_update = $this->update_by_id($data["id"], $data_article);

        $this->update_article_tag($data["id"], $data["tag_slugs"]);
    }


    /**
     *
     *
     */
     public function validate_password($data, $user)
     {
        // Filter password uncomplete.
        if (
            (! isset($data["password"])) ||
            ($data["password"] === "")
        )
        {
            return array(
                "result" => FALSE,
                "message" => "Passord not set or empty."
            );
        }
        else
        {
            $article = $this->select_by_id((int) $data["id"])["record"];

            // Filter password wrong.
            if (! password_verify($data["password"], $user["password_hash"]))
            {
                return array(
                    "result" => FALSE,
                    "message" => "Passord wrong."
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
    public function delete_data($data)
    {
        //$file_model = new file();
        $article_tag_model = new article_tag();
        $comment_model = new comment();

        $article_delete = $this->delete_by_id((int) $data["id"]);

        // Delete files..
        //$where = array(
        //    array(
        //        "field" => "article_id",
        //        "value" => (int) $data["id"],
        //        "operator" => "=",
        //        "condition" => "",
        //    ),
        //);
        //$file_delete = $file_model->where($where)->delete();

        // Delete article tag relation.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $data["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_delete = $article_tag_model->where($where)->delete();

        // Delete comments.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $data["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $comment_delete = $comment_model->where($where)->delete();
    }
}
?>
