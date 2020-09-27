<?php
namespace main\controllers;

use swdf\base\controller;

class home extends controller
{
    public function show()
    {
        return array(
            "home",
            array(
                "state" => "Y",
            )
        );
    }
}
?>
