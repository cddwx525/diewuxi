<?php
//include APP_PATH . "/{main_app_name}/urls.php";
//include APP_PATH . "/{other_app_name}/urls.php";
include APP_PATH . "/main/urls.php";
include APP_PATH . "/blog/urls.php";

class urls
{
    public function url_map()
    {
        //${main_app_name}_urls = new {main_app_name}\urls();
        //${other_app_name}_urls = new {other_app_name}\urls();
        $main_urls = new main\urls();
        $blog_urls = new blog\urls();

        $main_app_urls = $main_urls->url_map();

        $other_app_url = array(
            array(
                "^/blog",
                array("/blog"),
                array(""),
                $blog_urls->url_map(),
            ),
        );

        $url_map = array();
        $url_map = array_merge($url_map, $main_app_urls);
        $url_map = array_merge($url_map, $other_app_url);

        return $url_map;
    }
}
?>
