<?php
//include APP_PATH . "/{main_app_name}/urls.php";
//include APP_PATH . "/{other_app_name}/urls.php";

class urls
{
    public function url_map()
    {
        //${main_app_name}_urls = new {main_app_name}\urls();
        //${other_app_name}_urls = new {other_app_name}\urls();

        $app_url_map = array(
        //    array(
        //        "^/{other_app_name}",
        //        array("/{other_app_name}"),
        //        array(""),
        //        ${other_app_name}_urls->url_map(),
        //    ),
        );

        $url_map = array();

        /*
         * Add main app urls
         */
        //$url_map = array_merge($url_map, ${main_app_name}_urls->url_map());

        /*
         * Add other app urls
         */
        //$url_map = array_merge($url_map, ${other_app}_url_map);

        return $url_map;
    }
}
?>
