<?php
namespace swdf\base;

use swdf\helpers\html;

abstract class view
{
    protected $data = array();


    /**
     *
     *
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     *
     *
     */
    public function output_html()
    {
        $html = "<!DOCTYPE html>" . "\n" .
            html::tag(
                "html",
                $this->get_head() . "\n" .
                $this->get_body(),
                array()
            );

        print $html;
    }


    /**
     *
     *
     */
    abstract protected function get_head();


    /**
     *
     *
     */
    abstract protected function get_body();


    /**
     *
     *
     */
    public function output_text()
    {
        print $this->get_text();
    }


    /**
     *
     *
     */
    abstract protected function get_text();
}
?>
