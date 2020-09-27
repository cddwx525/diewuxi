<?php
namespace blog\controllers\guest;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\side_data;
use blog\models\page;
use blog\lib\Michelf\MarkdownExtra;

class home extends controller
{
    /**
     *
     *
     */
    protected function get_behaviors()
    {
        return array(
            array(
                "class" => init::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => array(
                        "common/not_config",
                        array()
                    )
                ),
            ),
            array(
                "class" => side_data::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => TRUE,
                )
            ),
        );
    }


    /**
     *
     *
     */
    public function show()
    {
        $page_model = new page();

        $home_page_id = \swdf::$app->data["options"]["home_page"];
        $home_page = $page_model->select_by_id((int) $home_page_id)["record"];

        $home_page["content"] = MarkdownExtra::defaultTransform($home_page["content"]);

        /*
        print("<pre>");
        print_r(\swdf::$app->data["category_tree"]);
        print("</pre>");
        exit();
        */

        return array(
            "guest/home",
            array(
                "home_page" => $home_page,
            ),
        );
    }
}
?>
