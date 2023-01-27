<?php
namespace main\controllers;

use swdf\base\controller;

class program extends controller
{
    public function index()
    {
        return array(
            "program/index",
            array(
            ),
        );
    }

    public function cwgcal()
    {
        if (isset(\swdf::$app->request["post"]["peak_value"]) === TRUE)
        {
            $peak_value = \swdf::$app->request["post"]["peak_value"];

            $half = (float) \swdf::$app->request["post"]["peak_value"] / 2;

            if (\swdf::$app->request["post"]["type"] === "voltage")
            {
                $type = "voltage";

                $v1 = (float) \swdf::$app->request["post"]["peak_value"] * 0.3;
                $v2 = (float) \swdf::$app->request["post"]["peak_value"] * 0.9;
            }
            else
            {
                if (\swdf::$app->request["post"]["type"] === "current")
                {
                    $type = "current";

                    $v1 = (float) \swdf::$app->request["post"]["peak_value"] * 0.1;
                    $v2 = (float) \swdf::$app->request["post"]["peak_value"] * 0.9;
                }
                else
                {
                }
            }
        }
        else
        {
            $type = "voltage";
            $peak_value = "";
            $half = "";
            $v1 = "";
            $v2 = "";
        }

        return array(
            "program/cwgcal",
            array(
                "peak_value" => $peak_value,
                "type" => $type,
                "half" => $half,
                "v1" => $v1,
                "v2" => $v2,
            ),
        );
    }
}
?>
