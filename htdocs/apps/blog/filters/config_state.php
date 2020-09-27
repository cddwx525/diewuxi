<?php
namespace blog\filters;

use blog\models\option;

class config_state
{
    /**
     *
     *
     */
    public function run()
    {
        return $this->get_is_configed();
    }


    /**
     *
     *
     */
    public function get_is_configed()
    {
        $option_model = new option();

        $options = array();

        foreach ($option_model->select()["record"] as $one_option)
        {
            $options[$one_option["name"]] = $one_option["value"];
        }

        if (
            (isset($options["flag"])) &&
            ($options["flag"] === "on")
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
