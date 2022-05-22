<?php
return array(
    "name" => "main",
    "title" => "Main app",
    "version" => "1.0.1",
    "params" => array(),

    "db_id" => NULL,

    "special_actions" => array(
        "default" => array("main", "home.show", ""),
        "not_found" => array("main", "not_found.show", ""),
    ),

    "meta_table" => NULL,
    "sql" => NULL,
);
?>
