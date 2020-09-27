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
        $option_model = new option();

        foreach ($option_model->select()["record"] as $one_option)
        {
            \swdf::$app->data["options"][$one_option["name"]] = $one_option["value"];
        }

        if (
            (isset(\swdf::$app->data["options"]["flag"])) &&
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
