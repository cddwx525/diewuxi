<?php
namespace blog\filters;

use blog\models\option;

class init
{
    /**
     *
     *
     */
    public function run()
    {
        return $this->init();
    }


    /**
     *
     *
     */
    public function init()
    {
        $option = new option();

        foreach ($option->select()["record"] as $one_option)
        {
            \swdf::$app->data["options"][$one_option["name"]] = $one_option["value"];
        }

        if (
            (isset(\swdf::$app->data["options"]["flag"]) === TRUE) &&
            (\swdf::$app->data["options"]["flag"] === "on")
        )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
?>
