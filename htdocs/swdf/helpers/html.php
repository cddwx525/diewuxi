<?php
namespace swdf\helpers;

class html
{
    /**
     *
     *
     */
    public static function tidy($string, $indent)
    {
       $indent_string = "    "; 
       $result = str_replace("\n", "\n" . str_repeat($indent_string, $indent), $string);
       $result = str_replace("\n" . str_repeat($indent_string, $indent) . "\n", "\n\n", $result);
       $result = str_repeat($indent_string, $indent) . $result;

       return $result;
    }


    /**
     *
     *
     */
    public static function inline_tag($tag, $content, $properties)
    {
        $result = "<" . $tag . self::get_property_string($properties) . ">" . $content . "</" . $tag . ">";

        return $result;
    }


    /**
     *
     *
     */
    public static function tag($tag, $content, $properties)
    {
        $result = "<" . $tag . self::get_property_string($properties) . ">" . "\n" . html::tidy($content, 1) . "\n" .  "</" . $tag . ">";

        return $result;
    }


    /**
     *
     *
     */
    public static function a($content, $href, $properties)
    {
        $result = "<a" . self::get_property_string($properties) . " href=\"" . $href . "\">" . $content . "</a>";

        return $result;
    }


    /**
     *
     *
     */
    public static function get_property_string($properties)
    {
        $property_string = "";
        foreach ($properties as $key => $value)
        {
            $property_string .= " " . $key . "=\"" . $value . "\"";
        }

        return $property_string;
    }
}
?>
