<?php
namespace main\controllers;

use swdf\base\controller;

class not_found extends controller
{
    public function show()
    {
        /*
         * Some operation.
         */
        return array(
            "not_found",
            array(
                "state" => "Y",
            )
        );
    }
}
?>
