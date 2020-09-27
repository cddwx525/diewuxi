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
    public function get_category($category)
    {
        $category = $this->get_base_category($category);
        $category["path"] = $this->get_path($category);
        $category["sub"] = $this->get_sub($category);

        return $category;
    }


    /**
     *
     *
     */
    public function get_base_category($category)
    {
        $category["full_slug"] = $this->get_full_slug($category);
        $category["full_name"] = $this->get_full_name($category);
        $category["article_count"] = $this->get_article_count($category);

        return $category;
    }


    /**
     *
     *
     */
    public function get_by_id($id)
    {
        return $this->get_category($this->select_by_id($id)["record"]);
    }


    /**
     *
     *
     */
    public function get_by_full_slug($full_slug)
    {
        $full_slug_list = $this->get_full_slug_data($full_slug);

        foreach ($full_slug_list as $key => $slug)
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
                        "value" => $full_slug_list[0],
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
                        "value" => (int) $category["id"],
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

            $category = $this->where($where)->select_first()["record"];
        }

        return $this->get_category($category);
    }


    /**
     *
     *
     */
    public function get_articles($category)
    {
        $article_model = new article();

        // Get articles belonged to category.
        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $category["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $articles = $article_model->where($where)->select()["record"];

        // Add relate data to article.
        foreach ($articles as $key => $article)
        {
            $articles[$key] = $article_model->get_article($article);
        }

        return $articles;
    }


    /**
     *
     *
     */
    public function get_all_articles($category)
    {
        $article_model = new article();

        $categories = array();
        $categories[] = $category;
        $categories = array_merge($categories, $this->get_all_sub($category));


        // Get articles belonged to category.
        $where = array();
        $where[0] = "OR";
        foreach ($categories as $one_category)
        {
            $where[1][] = array(
                "field" => "category_id",
                "value" => (int) $one_category["id"],
                "operator" => "=",
            );
        }
        $articles = $article_model->batch_where($where)->order(array("`date` DESC"))->select()["record"];


        // Add relate data to article.
        foreach ($articles as $key => $article)
        {
            $articles[$key] = $article_model->get_article($article);
        }

        return $articles;
    }


    /**
     * Get article_count.
     *
     */
    public function get_article_count($category)
    {
        $article_model = new article();

        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $category["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        return $article_model->where($where)->select_count()["record"];
    }


    /**
     * Category array tree.
     *
     */
    public function get_tree()
    {
        $where = array(
            array(
                "field" => "parent_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $category_tree = $this->hierarchy($this->where($where)->select()["record"]);

        return $category_tree;
    }


    /**
     *
     *
     */
    private function hierarchy($categories)
    {
        foreach ($categories as $key => $category)
        {
            $categories[$key] = $this->get_category($category);

            // Get sub categories.
            $subcategories = $this->get_sub($category);

            if (! empty($subcategories))
            {
                $categories[$key]["son"] = $this->hierarchy($subcategories);
            }
            else
            {
                $categories[$key]["son"] = NULL;
            }
        }

        return $categories;
    }


    /**
     * Category list from a category up to top category.
     *
     */
    public function get_path($category)
    {
        $category_list = array();

        $category_list[] = $this->get_base_category($category);

        while ($category["parent_id"] != NULL)
        {
            $category = $this->select_by_id((int) $category["parent_id"])["record"];

            $category_list[] = $this->get_base_category($category);
        }

        krsort($category_list, SORT_NUMERIC);

        return $category_list;
    }


    /**
     * Sub category list of a category.
     *
     */
    private function get_sub($category)
    {
        $where = array(
            array(
                "field" => "parent_id",
                "value" => (int) $category["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $sub_categories = $this->where($where)->select()["record"];

        foreach ($sub_categories as $key => $one_category)
        {
            $sub_categories[$key] = $this->get_base_category($one_category);
        }

        return $sub_categories;
    }


    /**
     * All sub category list of a category.
     *
     */
    private function get_all_sub($category)
    {
        $all_sub_categories = $this->recusive_all_sub($category);

        return $all_sub_categories;
    }


    /**
     *
     *
     */
    private function recusive_all_sub($category)
    {
        $sub_categories = $this->get_sub($category);

        $all_sub_categories = array();
        if (! empty($sub_categories))
        {
            foreach ($sub_categories as $one_category)
            {
                $all_sub_categories[] = $one_category;
                $all_sub_categories = array_merge($all_sub_categories, $this->get_all_sub($one_category));
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
    public function get_full_slug($category)
    {
        $slug_list = array();
        $slug_list[] = $category["slug"];

        while ($category["parent_id"] != NULL)
        {
            $category = $this->select_by_id((int) $category["parent_id"])["record"];

            $slug_list[] = $category["slug"];
        }

        krsort($slug_list, SORT_NUMERIC);

        return $this->get_full_slug_by_data($slug_list);
    }


    /**
     *
     *
     */
    public function get_is_full_slug($full_slug)
    {
        $full_slug_list = $this->get_full_slug_data($full_slug);

        // Filter wrong category slug.
        foreach ($full_slug_list as $key => $value)
        {
            $where = array(
                array(
                    "field" => "slug",
                    "value" => $value,
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $category = $this->where($where)->select_first()["record"];

            // Filter not exist category.
            if (
                ($category === FALSE)
            )
            {
                return FALSE;
            }
            else
            {
            }

            // Filter not root category.
            if (
                ($key === 0) 
            )
            {
                if (
                    ($category["parent_id"] != NULL)
                )
                {
                    return FALSE;
                }
                else
                {
                }
            }
            else
            {
                $parent_category = $this->select_by_id((int) $category["parent_id"])["record"];

                // Filter not son category of previous.
                if (
                    ($parent_category === FALSE) ||
                    ($parent_category["slug"] != $full_slug_list[$key - 1])
                )
                {
                    return FALSE;
                }
                else
                {
                }
            }
        }
        return TRUE;
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
    public function get_full_name($category)
    {
        $name_list = array();
        $name_list[] = $category["name"];

        while ($category["parent_id"] != NULL)
        {
            $category = $this->select_by_id((int) $category["parent_id"])["record"];

            $name_list[] = $category["name"];
        }

        krsort($name_list, SORT_NUMERIC);

        return "/" . implode("/", $name_list);
    }
}
?>
