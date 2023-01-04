<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class category_side extends widget
{
    /**
     *
     *
     */
    protected function run($config)
    {
        return $this->get_html($config["data"]);
    }



    /**
     *
     *
     */
    private function get_html($categories)
    {
        if (empty($categories) === TRUE)
        {
            $html = "<p>There is no category now.</p>";
        }
        else
        {
            $html = $this->recusive_categories($categories);
        }

        return $html;
    }

    /**
     *
     *
     */
    private function recusive_categories($categories)
    {
        $category_link_list = array();

        foreach ($categories as $category)
        {
            $category_link_list[] = html::inline_tag(
                "li",
                html::a(
                    htmlspecialchars($category->record["name"]),
                    url::get(
                        array(\swdf::$app->name, "guest/article.slug_list_by_category", ""),
                        array("full_category_slug" => $category->get_full_slug()),
                        ""
                    ),
                    array()
                ) .
                html::inline_tag(
                    "span",
                    "[" . $category->get_article_count() . "]",
                    array()
                ),
                array()
            );

            $sub_categories = $category->get_sub();

            if (empty($sub_categories) === FALSE)
            {
                $category_link_list[] = $this->recusive_categories($sub_categories);
            }
            else
            {
            }
        }

        return html::tag("ul", implode("\n", $category_link_list), array());
    }
}
?>
