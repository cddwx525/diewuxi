<?php
namespace blog\controllers\common;

use blog\lib\controllers\simple;

class not_found extends simple
{
    public function show($parameters)
    {
        /*
         * Some operation.
         */
        $view_name = "common/not_found";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
        );
    }
}
?>
