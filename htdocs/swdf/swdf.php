<?php
include __DIR__ . "/swdf_base.php";


class swdf extends swdf\swdf_base
{
}

// autoload
spl_autoload_register("swdf::load_class");
swdf::set_php();
?>
