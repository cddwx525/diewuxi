<?php
namespace blog\controllers\guest;

use blog\lib\controllers\guest_base;
use blog\lib\Michelf\MarkdownExtra;
use blog\models\page;

class home extends guest_base
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

        $home_page = $this->meta_data["options"]["home_page"];
        $home_page_page = $table_page->select_by_id((int) $home_page)["record"];

        $home_page_page["content"] = MarkdownExtra::defaultTransform($home_page_page["content"]);

        $view_name = "guest/home";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "home_page_page" => $home_page_page,
        );
    }
}
?>
