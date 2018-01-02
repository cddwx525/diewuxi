<?php
namespace blog\controllers\admin;

use blog\lib\url;
use blog\lib\Michelf\MarkdownExtra;
use blog\lib\controllers\admin_base;
use blog\models\article as article_model;
use blog\models\tag as tag_model;
use blog\models\category as category_model;
use blog\models\media as media_model;
use blog\models\comment as comment_model;
use blog\models\article_tag as article_tag_model;
use blog\models\user as user_model;

class article extends admin_base
{
    public function list_all($parameters)
    {
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_media = new media_model();
        $table_comment = new comment_model();
        $table_article_tag = new article_tag_model();

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

        // Get articles.
        $articles = $table_article->order(array("`date` DESC"))->select()["record"];

        // Add relate data.
        foreach ($articles as $key => $article)
        {
            // Add category data.
            $article["category"] = $table_category->select_by_id((int) $article["category_id"])["record"];

            // Add tags data.
            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article_tag_relations = $table_article_tag->where($where)->select()["record"];
            $article_tag = array();
            foreach ($article_tag_relations as $article_tag_relation)
            {
                $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation["tag_id"])["record"];
            }
            $article["tag"] = $article_tag;

            // Comment count.
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
            $article["comment_count"] = $table_comment->where($where)->select_count()["record"];

            // Add media count.
            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article["media_count"] = $table_media->where($where)->select_count()["record"];

            $articles[$key] = $article;
        }

        $view_name = "admin/article/list_all";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "articles" => $articles,
        );
    }


    public function list_category($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_media = new media_model();
        $table_comment = new comment_model();
        $table_article_tag = new article_tag_model();

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

        // Filter wrong category_id.
        if (
            (! isset($parameters["get"]["category_id"])) ||
            ($parameters["get"]["category_id"] === "") ||
            ($table_category->select_by_id((int) $parameters["get"]["category_id"])["record"] === FALSE)
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

        // Get category.
        $category = $table_category->select_by_id((int) $parameters["get"]["category_id"])["record"];

        // Get articles belonged to category.
        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $parameters["get"]["category_id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $articles = $table_article->where($where)->select()["record"];

        // Add relate data to article.
        foreach ($articles as $key => $article)
        {
            // Add category.
            $article["category"] = $category;

            // Add tags.
            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article_tag_relations = $table_article_tag->where($where)->select()["record"];
            $article_tag = array();
            foreach ($article_tag_relations as $article_tag_relation)
            {
                $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation["tag_id"])["record"];
            }
            $article["tag"] = $article_tag;

            // Add comment count.
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
            $article["comment_count"] = $table_comment->where($where)->select_count()["record"];

            // Add media count.
            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article["media_count"] = $table_media->where($where)->select_count()["record"];

            $articles[$key] = $article;
        }

        $view_name = "admin/article/list_category";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "category" => $category,
            "articles" => $articles,
        );
    }


    public function list_tag($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_media = new media_model();
        $table_comment = new comment_model();
        $table_article_tag = new article_tag_model();

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

        // Filter wrong tag_id.
        if (
            (! isset($parameters["get"]["tag_id"])) ||
            ($parameters["get"]["tag_id"] === "") ||
            ($table_tag->select_by_id((int) $parameters["get"]["tag_id"])["record"] === FALSE)
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

        // Get tag.
        $tag = $table_tag->select_by_id((int) $parameters["get"]["tag_id"])["record"];

        // Get article_tag_relations.
        $where = array(
            array(
                "field" => "tag_id",
                "value" => (int) $tag["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_relations = $table_article_tag->where($where)->select()["record"];

        // Get articles belonged to tag.
        $articles = array();
        foreach ($article_tag_relations as $article_tag_relation)
        {
            // Get one article.
            $article = $table_article->select_by_id((int) $article_tag_relation["article_id"])["record"];

            // Add category data.
            $article["category"] = $table_category->select_by_id((int) $article["category_id"])["record"];

            // Add tags data.
            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article_tag_relations_second = $table_article_tag->where($where)->select()["record"];
            $article_tag = array();
            foreach ($article_tag_relations_second as $article_tag_relation_second)
            {
                $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation_second["tag_id"])["record"];
            }
            $article["tag"] = $article_tag;

            // Add comment count data.
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
            $article["comment_count"] = $table_comment->where($where)->select_count()["record"];

            // Add media count.
            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article["media_count"] = $table_media->where($where)->select_count()["record"];

            $articles[] = $article;
        }

        $view_name = "admin/article/list_tag";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "tag" => $tag,
            "articles" => $articles,
        );
    }


    public function show($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_comment = new comment_model();
        $table_article_tag = new article_tag_model();
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

        // Filter wrong article_id.
        if (
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_article->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
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
        $article = $table_article->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add category data.
        $article["category"] = $table_category->select_by_id((int) $article["category_id"])["record"];

        // Add tags data.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $article["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_relations = $table_article_tag->where($where)->select()["record"];
        $article_tag = array();
        foreach ($article_tag_relations as $article_tag_relation)
        {
            $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation["tag_id"])["record"];
        }
        $article["tag"] = $article_tag;

        // Convert markdown to html.
        $article["content"] = MarkdownExtra::defaultTransform($article["content"]);

        // Get comment count.
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
        $comment_count = $table_comment->where($where)->select_count()["record"];

        // Get comments.
        $comments = $this->comment_hierarchy($table_comment->where($where)->order(array("`number` ASC"))->select()["record"], $table_comment);

        // Generate form stamp.
        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));
        session_start(["read_and_close" => TRUE,]);

        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $table_user->where($where)->update(array("form_stamp" => $form_stamp,));

        $view_name = "admin/article/show";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "article" => $article,
            "comment_count" => $comment_count,
            "comments" => $comments,
            "form_stamp" => $form_stamp,
        );
    }


    public function write($parameters)
    {
        $table_user = new user_model();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();

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

        // Get categories.
        $where = array(
            array(
                "field" => "parent_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $categories = $this->category_hierarchy($table_category->where($where)->select()["record"], $table_category, $table_article);

        // Get tags.
        $tags = $table_tag->select()["record"];

        // Genrate form stamp.
        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));
        session_start(["read_and_close" => TRUE,]);

        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $table_user->where($where)->update(array("form_stamp" => $form_stamp,));


        $view_name = "admin/article/write";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "categories" => $categories,
            "tags" => $tags,
            "form_stamp" => $form_stamp,
        );
    }


    public function add($parameters)
    {
        $table_article = new article_model();
        $table_tag = new tag_model();
        $table_category = new category_model();
        $table_article_tag = new article_tag_model();
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

        // Get user.
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
            $view_name = "admin/article/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "XSRF",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Filter uncomplete.
        if (
            (! isset($parameters["post"]["date"])) ||
            ($parameters["post"]["date"] === "") ||
            (! isset($parameters["post"]["title"])) ||
            ($parameters["post"]["title"] === "") ||
            (! isset($parameters["post"]["content"])) ||
            ($parameters["post"]["content"] === "") ||
            (! isset($parameters["post"]["keywords"])) ||
            ($parameters["post"]["keywords"] === "") ||
            (! isset($parameters["post"]["description"])) ||
            ($parameters["post"]["description"] === "") ||
            (! isset($parameters["post"]["category_name"])) ||
            ($parameters["post"]["category_name"] === "") ||
            (! isset($parameters["post"]["tag_name"])) ||
            ($parameters["post"]["tag_name"] === "")
        )
        {
            $view_name = "admin/article/add";

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

        // Get category record.
        $where = array(
            array(
                "field" => "name",
                "value" => $parameters["post"]["category_name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $category = $table_category->where($where)->select_first()["record"];

        // Filter not exist category.
        if ($category === FALSE)
        {
            $view_name = "admin/article/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "CATEGORY_NOT_EXIST",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Add article.
        $data_article = array(
            "slug"          => $parameters["post"]["slug"],
            "date"          => $parameters["post"]["date"],
            "title"         => $parameters["post"]["title"],
            "content"       => $parameters["post"]["content"],
            "keywords"      => $parameters["post"]["keywords"],
            "description"   => $parameters["post"]["description"],
            "category_id"   => (int) $category["id"],
        );

        try
        {
            $article_add = $table_article->add($data_article);
        }
        catch (\PDOException $e)
        {
            // Filter article add fail.
            $view_name = "admin/article/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "ARTICLE_ADD_FAIL",
                "parameters" => $parameters,
            );
        }

        // Add tags.
        $tag_names = explode(", ", $parameters["post"]["tag_name"]);
        foreach ($tag_names as $tag_name)
        {
            $where = array(
                array(
                    "field" => "name",
                    "value" => $tag_name,
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $tag = $table_tag->where($where)->select_first()["record"];

            if ($tag === FALSE)
            {
                // Tag not exist, add.
                try
                {
                    $tag_add = $table_tag->add(array("name" => $tag_name));
                }
                catch (\PDOException $e)
                {
                    // Filter tag add fail. roll back, delete article.
                    try
                    {
                        $table_article->delete_by_id($article_add["last_id"]);
                    }
                    catch (\PDOException $e)
                    {
                        // Filter article roll back delete fail.
                        $view_name = "admin/article/add";

                        return array(
                            "meta_data" => $this->meta_data,
                            "view_name" => $view_name,
                            "state" => "TAG_NEW_ADD_FAIL_ARTICLE_DELETE_FAIL",
                            "parameters" => $parameters,
                        );
                    }

                    $view_name = "admin/article/add";

                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => $view_name,
                        "state" => "TAG_NEW_ADD_FAIL",
                        "parameters" => $parameters,
                    );
                }

                // Add article tag relation.
                $data_article_tag = array(
                    "article_id"    => (int) $article_add["last_id"],
                    "tag_id"        => (int) $tag_add["last_id"],
                );

                try
                {
                    $article_tag_add = $table_article_tag->add($data_article_tag);
                }
                catch (\PDOException $e)
                {
                    // Filter article tag add fail.
                    try
                    {
                        $table_article->delete_by_id($article_add["last_id"]);
                    }
                    catch (\PDOException $e)
                    {
                        // Filter article roll back delete fail.
                        $view_name = "admin/article/add";

                        return array(
                            "meta_data" => $this->meta_data,
                            "view_name" => $view_name,
                            "state" => "ARTICLE_TAG_NEW_ADD_FAIL-ARTICLE_DELETE_FAIL",
                            "parameters" => $parameters,
                        );
                    }

                    try
                    {
                        $table_tag->delete_by_id($tag_add["last_id"]);
                    }
                    catch (\PDOException $e)
                    {
                        // Filter tag roll back delete fail.
                        $view_name = "admin/article/add";

                        return array(
                            "meta_data" => $this->meta_data,
                            "view_name" => $view_name,
                            "state" => "ARTICLE_TAG_NEW_ADD_FAIL-TAG_DELETE_FAIL",
                            "parameters" => $parameters,
                        );
                    }

                    $view_name = "admin/article/add";

                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => $view_name,
                        "state" => "ARTICLE_TAG_NEW_ADD_FAIL",
                        "parameters" => $parameters,
                    );
                }
            }
            else
            {
                // Tag exists.

                // Add article tag relation data.
                $data_article_tag = array(
                    "article_id"    => (int) $article_add["last_id"],
                    "tag_id"        => (int) $tag["id"],
                );

                try
                {
                    $article_tag_add = $table_article_tag->add($data_article_tag);
                }
                catch (\PDOException $e)
                {
                    // Filter article tag add fail.
                    try
                    {
                        $table_article->delete_by_id($article_add["last_id"]);
                    }
                    catch (\PDOException $e)
                    {
                        // Filter article roll back delete fail.
                        $view_name = "admin/article/add";

                        return array(
                            "meta_data" => $this->meta_data,
                            "view_name" => $view_name,
                            "state" => "ARTICLE_TAG_ADD_FAIL-ARTICLE_DELETE_FAIL",
                            "parameters" => $parameters,
                        );
                    }

                    $view_name = "admin/article/add";

                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => $view_name,
                        "state" => "ARTICLE_TAG_ADD_FAIL",
                        "parameters" => $parameters,
                    );
                }
            }
        }

        $view_name = "admin/article/add";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
            "article_add" => $article_add,
        );
    }


    public function edit($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_article_tag = new article_tag_model();
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

        // Filter wrong article id.
        if (
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_article->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
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
        $article = $table_article->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add category data.
        $article["category"] = $table_category->select_by_id((int) $article["category_id"])["record"];

        // Add tags data.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $article["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_relations = $table_article_tag->where($where)->select()["record"];
        $article_tag = array();
        foreach ($article_tag_relations as $article_tag_relation)
        {
            $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation["tag_id"])["record"];
        }
        $article["tag"] = $article_tag;


        // Get categories record.
        $where = array(
            array(
                "field" => "parent_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $categories = $this->category_hierarchy($table_category->where($where)->select()["record"], $table_category, $table_article);

        // Get tags record.
        $tags = $table_tag->select()["record"];

        // Generate form stamp.
        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));
        session_start(["read_and_close" => TRUE,]);

        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $table_user->where($where)->update(array("form_stamp" => $form_stamp,));


        $view_name = "admin/article/edit";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "article" => $article,
            "categories" => $categories,
            "tags" => $tags,
            "form_stamp" => $form_stamp,
        );
    }


    public function update($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_tag = new tag_model();
        $table_category = new category_model();
        $table_article_tag = new article_tag_model();
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

        // Filter wrong article id.
        if (
            (! isset($parameters["post"]["id"])) ||
            ($parameters["post"]["id"] === "") ||
            ($table_article->select_by_id((int) $parameters["post"]["id"])["record"] === FALSE)
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
            $view_name = "admin/article/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "XSRF",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Filter uncomplete.
        if (
            (! isset($parameters["post"]["date"])) ||
            ($parameters["post"]["date"] === "") ||
            (! isset($parameters["post"]["title"])) ||
            ($parameters["post"]["title"] === "") ||
            (! isset($parameters["post"]["content"])) ||
            ($parameters["post"]["content"] === "") ||
            (! isset($parameters["post"]["keywords"])) ||
            ($parameters["post"]["keywords"] === "") ||
            (! isset($parameters["post"]["description"])) ||
            ($parameters["post"]["description"] === "") ||
            (! isset($parameters["post"]["category_name"])) ||
            ($parameters["post"]["category_name"] === "") ||
            (! isset($parameters["post"]["tag_name"])) ||
            ($parameters["post"]["tag_name"] === "")
        )
        {
            $view_name = "admin/article/update";

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

        // Get category record.
        $where = array(
            array(
                "field" => "name",
                "value" => $parameters["post"]["category_name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $category = $table_category->where($where)->select_first()["record"];

        // Filter not exist category.
        if ($category === FALSE)
        {
            $view_name = "admin/article/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "CATEGORY_NOT_EXIST",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Update article.
        $data_article = array(
            "slug"          => $parameters["post"]["slug"],
            "date"          => $parameters["post"]["date"],
            "title"         => $parameters["post"]["title"],
            "content"       => $parameters["post"]["content"],
            "keywords"      => $parameters["post"]["keywords"],
            "description"   => $parameters["post"]["description"],
            "category_id"   => (int) $category["id"],
        );

        try
        {
            $article_update = $table_article->update_by_id((int) $parameters["post"]["id"], $data_article);
        }
        catch (\PDOException $e)
        {
            // Filter article update fail.
            $view_name = "admin/article/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "ARTICLE_UPDATE_FAIL",
                "parameters" => $parameters,
            );
        }


        // Clean article tag record.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $parameters["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        try
        {
            $article_tag_delete = $table_article_tag->where($where)->delete();
        }
        catch (\PDOException $e)
        {
            // Filter article tag record delete fail.
            $view_name = "admin/article/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "ARTICLE_TAG_DELETE_FAIL",
                "parameters" => $parameters,
            );
        }

        // Update tags.
        $tag_names = explode(", ", $parameters["post"]["tag_name"]);
        foreach ($tag_names as $tag_name)
        {
            // Get tag record.
            $where = array(
                array(
                    "field" => "name",
                    "value" => $tag_name,
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $tag = $table_tag->where($where)->select_first()["record"];

            if ($tag === FALSE)
            {
                // Tag not exist, add.
                try
                {
                    $tag_add = $table_tag->add(array("name" => $tag_name));
                }
                catch (\PDOException $e)
                {
                    // Filter tag add fail.
                    $view_name = "admin/article/update";

                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => $view_name,
                        "state" => "TAG_NEW_ADD_FAIL",
                        "parameters" => $parameters,
                    );
                }

                // Add article tag relation.
                $data_article_tag = array(
                    "article_id"    => (int) $parameters["post"]["id"],
                    "tag_id"        => (int) $tag_add["last_id"],
                );

                try
                {
                    $article_tag_add = $table_article_tag->add($data_article_tag);
                }
                catch (\PDOException $e)
                {
                    // Filter article tag add fail.
                    try
                    {
                        $table_tag->delete_by_id($tag_add["last_id"]);
                    }
                    catch (\PDOException $e)
                    {
                        // Filter tag roll back delete fail.
                        $view_name = "admin/article/update";

                        return array(
                            "meta_data" => $this->meta_data,
                            "view_name" => $view_name,
                            "state" => "ARTICLE_TAG_NEW_ADD_FAIL-TAG_DELETE_FAIL",
                            "parameters" => $parameters,
                        );
                    }

                    $view_name = "admin/article/update";

                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => $view_name,
                        "state" => "ARTICLE_TAG_NEW_ADD_FAIL",
                        "parameters" => $parameters,
                    );
                }
            }
            else
            {
                // Tag exists.

                // Add article tag relation data.
                $data_article_tag = array(
                    "article_id"    => (int) $parameters["post"]["id"],
                    "tag_id"        => (int) $tag["id"],
                );

                try
                {
                    $article_tag_add = $table_article_tag->add($data_article_tag);
                }
                catch (\PDOException $e)
                {
                    // Filter article tag add fail.
                    $view_name = "admin/article/update";

                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => $view_name,
                        "state" => "ARTICLE_TAG_ADD_FAIL",
                        "parameters" => $parameters,
                    );
                }
            }
        }

        $view_name = "admin/article/update";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
        );
    }


    public function delete_confirm($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_comment = new comment_model();
        $table_article_tag = new article_tag_model();

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

        // Filter wrong article id.
        if (
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_article->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
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
        $article = $table_article->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add category data.
        $article["category"] = $table_category->select_by_id((int) $article["category_id"])["record"];

        // Add tags data.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $article["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_relations = $table_article_tag->where($where)->select()["record"];
        $article_tag = array();
        foreach ($article_tag_relations as $article_tag_relation)
        {
            $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation["tag_id"])["record"];
        }
        $article["tag"] = $article_tag;


        // Get comment count.
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
        $comment_count = $table_comment->where($where)->select_count()["record"];

        $view_name = "admin/article/delete_confirm";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "article" => $article,
            "comment_count" => $comment_count,
        );
    }


    public function delete($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_comment = new comment_model();
        $table_article_tag = new article_tag_model();
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

        // Filter wrong article id.
        if (
            (! isset($parameters["post"]["id"])) ||
            ($parameters["post"]["id"] === "") ||
            ($table_article->select_by_id((int) $parameters["post"]["id"])["record"] === FALSE)
        )
        {
            $view_name = "admin/article/delete";

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


        // Filter password uncomplete.
        if (
            (! isset($parameters["post"]["password"])) ||
            ($parameters["post"]["password"] === "")
        )
        {
            $view_name = "admin/article/delete";

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

        // Get article record.
        $article = $table_article->select_by_id((int) $parameters["post"]["id"])["record"];

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


        // Filter password wrong.
        if (password_verify($parameters["post"]["password"], $one_user["password_hash"]) === FALSE)
        {
            $view_name = "admin/article/delete";

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


        // Delete article.
        try
        {
            $article_delete = $table_article->delete_by_id((int) $parameters["post"]["id"]);
        }
        catch (\PDOException $e)
        {
            // Filter article delete fail.
            $view_name = "admin/article/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "ARTICLE_DELETE_FAIL",
                "parameters" => $parameters,
            );
        }

        // Delete article tag relation.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $parameters["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        try
        {
            $article_tag_delete = $table_article_tag->where($where)->delete();
        }
        catch (\PDOException $e)
        {
            // Filter article tag relation delete fail.
            $view_name = "admin/article/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "ARTICLE_TAG_DELETE_FAIL",
                "parameters" => $parameters,
            );
        }

        // Delete comments.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $parameters["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        try
        {
            $comment_delete = $table_comment->where($where)->delete();
        }
        catch (\PDOException $e)
        {
            // Filter comments delete fail.
            $view_name = "admin/article/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "COMMENT_DELETE_FAIL",
                "parameters" => $parameters,
            );
        }

        $view_name = "admin/article/delete";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
        );
    }


    private function category_hierarchy($categories, $table_category, $table_article)
    {
        foreach ($categories as $key => $category)
        {
            // Add article count data to categories.
            $where = array(
                array(
                    "field" => "category_id",
                    "value" => (int) $category["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $category["article_count"] = $table_article->where($where)->select_count()["record"];

            $categories[$key] = $category;

            // Get sub categories.
            $where = array(
                array(
                    "field" => "parent_id",
                    "value" => (int) $category["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $subcategories = $table_category->where($where)->select()["record"];

            if (! empty($subcategories))
            {
                $categories[$key]["son"] = $this->category_hierarchy($subcategories, $table_category, $table_article);
            }
            else
            {
            }
        }

        return $categories;
    }


    private function comment_hierarchy($comments, $table_comment)
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
            $subcomments = $table_comment->where($where)->order(array("`date` ASC"))->select()["record"];
            if ($subcomments != array())
            {
                $comments[$key]["reply"] = $this->comment_hierarchy($subcomments, $table_comment);
            }
            else
            {
            }
        }
        return $comments;
    }
}
?>
