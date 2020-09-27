<?php
namespace blog\filters;

use blog\models\option;
use blog\models\tag;
use blog\models\category;

class init
{
    /**
     *
     *
     */
    public function run()
    {
        $this->set_options();
        $this->set_common();


        return TRUE;
    }


    /**
     *
     *
     */
    public function set_options()
    {
        $option_model = new option();

        $options = array();

        foreach ($option_model->select()["record"] as $one_option)
        {
            \swdf::$app->data["options"][$one_option["name"]] = $one_option["value"];
        }
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
