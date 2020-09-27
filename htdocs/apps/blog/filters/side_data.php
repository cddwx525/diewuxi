<?php
namespace blog\filters;

use blog\models\tag;
use blog\models\category;

class side_data
{
    /**
     *
     *
     */
    public function run()
    {
        $this->set_common();

        return TRUE;
    }


    /**
     *
     *
     */
    public function set_common()
    {
        $category_model = new category();
        $tag_model = new tag();


        \swdf::$app->data["category_tree"] = $category_model->get_tree();
        \swdf::$app->data["tags"] = $tag_model->get_tags();
    }
}
?>
