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
        $category = new category();
        $tag = new tag();


        \swdf::$app->data["root_categories"] = $category->get_root();
        \swdf::$app->data["tags"] = $tag->find_all();
    }
}
?>
