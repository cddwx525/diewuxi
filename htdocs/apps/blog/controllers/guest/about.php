<?php
namespace blog\controllers\guest;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\side_data;
use blog\models\page;
use blog\lib\Michelf\MarkdownExtra;

class about extends controller
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

        $about_page_id = \swdf::$app->data["options"]["about_page"];
        $about_page = $page_model->select_by_id((int) $about_page_id)["record"];

        $about_page["content"] = MarkdownExtra::defaultTransform($about_page["content"]);


        return array(
            "guest/about",
            array(
                "about_page" => $about_page,
            ),
        );
    }
}
?>
