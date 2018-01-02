<?php
namespace main\controllers;

use main\lib\controllers\base as base;

class not_found extends base
{
    public function show($parameters)
    {
        /*
         * Some operation.
         */
        $view_name = "not_found";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
        );
    }
}
?>
