<?php
namespace blog\controllers\guest;

use blog\lib\controllers\guest_base;
use blog\lib\Michelf\MarkdownExtra;
use blog\models\page;

class about extends guest_base
{
    public function show($parameters)
    {
        $table_page = new page();

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

        $about_page = $this->meta_data["options"]["about_page"];
        $about_page_page = $table_page->select_by_id((int) $about_page)["record"];

        $about_page_page["content"] = MarkdownExtra::defaultTransform($about_page_page["content"]);

        $view_name = "guest/about";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "about_page_page" => $about_page_page,
        );
    }
}
?>
