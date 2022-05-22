<?php
namespace swdf\base;

abstract class widget
{
    /**
     *
     *
     */
    public static function widget($config)
    {
        $result = new static();

        return $result->run($config);
    }


    /**
     *
     *
     */
    abstract protected function run($config);
}
?>
