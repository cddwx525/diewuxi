<?php
namespace blog;

use blog\app_setting;

class app_main extends \start_app
{
    public function run($dynamic_match)
    {
        $app_setting = new app_setting();

        $this->route($dynamic_match, $app_setting);
    }
}
?>
