<?php
include APP_PATH . "/forum/urls.php";

class urls
{
    public function url_map()
    {
        $forum_urls = new forum\urls();

        return array(
            array(
                "^$",
                array(""),
                array(""),
                array(MAIN_APP, "", "", "301", array("", "", "/"),),
                array("", "", ""),
            ),
            array(
                "^/$",
                array("/"),
                array(""),
                array(MAIN_APP, "", "", "301", array(MAIN_APP, "", "/"),),
                array("", "", "/"),
            ),
            array(
                "^/forum",
                array("/forum"),
                array(""),
                $forum_urls->url_map(),
            ),
        );
    }
}
?>
