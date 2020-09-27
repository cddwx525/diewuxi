<?php
namespace main\controllers;

use swdf\base\controller;

class one_page extends controller
{
    public function show()
    {
        return array(
            "one_page",
            array(
                "state" => "Y",
            )
        );
    }
}
?>
