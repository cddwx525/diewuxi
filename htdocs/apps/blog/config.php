<?php
return array(
    "name" => "blog",
    "title" => "Blog",
    "version" => "1.0.0",
    "params" => array(
    ),

    "db_id" => array(
        "host" => "localhost",
        "name" => "swdf_testblog",
        "user" => "swdf_testblog",
        "password" => "swdf_testblog",
    ),

    "special_actions" => array(
        "default" => array("blog", "guest/home.show", ""),
        "not_found" => array("blog", "common/not_found.show", ""),
    ),

    "meta_table" => "option",
    "sql" => "",
);
?>
