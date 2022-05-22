<?php
return array(
    "name" => "blog",
    "title" => "SWDF test blog",
    "version" => "1.0.1",
    "params" => array(
        "file_folder" => "uploads",
        "default_file_folder" => "uploads",
        "file_host" => "local",
        "default_file_host" => "local",
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
