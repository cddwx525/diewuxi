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

       // Insert indent before every html tag before which only spaces exist.
       $result = preg_replace("/^( *)</m", str_repeat($indent_string, $indent) . "\\1<", $string);

       return $result;
    }

    /**
     *
     *
     */
    public static function mono_tag($tag, $properties)
    {
        $result = "<" . $tag . self::get_property_string($properties) . " />";

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
