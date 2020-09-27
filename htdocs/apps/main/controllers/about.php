<?php
namespace main\controllers;

use swdf\base\controller;

class about extends controller
{
    public function show()
    {
        return array(
            "about",
            array(
                "state" => "Y",
            ),
        );
    }
}
?>
