<?php
namespace main\views;

use swdf\helpers\html;
use swdf\helpers\url;
use main\views\layouts\base;

class about extends base
{
    public function set_items()
    {
        $this->title = "About";
        $this->position = array("About");

        $this->main = html::tag(
            "div",
            html::inline_tag("h3", "Introduction to Diewuxi:", array()) . "\n\n" .
            html::inline_tag(
                "p",
                "\"Diewuxi(蝶舞溪)\" is a river in my hometown, near \"village YangLianZhuang(杨令庄村)\". My friend Liu Yong-Sheng lives there.
 In year 2009, Liu and I study at Yexian second highshool in grade two. In a holiday, I goto Liu's home with him and stay there for several days. One day we go out to a mountain nearby which we have not visit.
 We brough some food then set off. We took long time to climp over the mountain, and then found a river. The river is beautiful and we were very happy after long trip. More surprisingly, there is a big flat stone beside the river, written \"蝶舞溪\".
 We were very happy about it, and had a rest there. After this journal, the \"蝶舞溪\" stayed in my brain, I even changed my social network nickname to \"曾到蝶舞溪\".",
                array()
            ) . "\n\n" .
            html::inline_tag(
                "p",
                "Many years past, I have never been there again, but the place will keep in my mind forever.",
                array()
            ) . "\n\n" .
            html::inline_tag("h3", "Site changelog:", array()) . "\n\n" .
            html::tag(
                "ul",
                html::inline_tag(
                    "li",
                    html::inline_tag("span", "v2.0 2023-01-04", array("class" => "text-padding")),
                    array()
                ) . "\n" .
                html::tag(
                    "ul",
                    html::inline_tag("li", "New program design, more convenience for develop, especially with database operation.", array()) . "\n" .
                    html::inline_tag("li", "Simple interface style(Because I can not do it good).", array()) . "\n" .
                    html::inline_tag("li", "Html code is strictly indent.", array()) . "\n" .
                    html::mono_tag("br", array()),
                    array()
                ) . "\n" .
                html::inline_tag(
                    "li",
                    html::inline_tag("span", "v1.0 2017-09-18", array("class" => "text-padding")) .
                    html::a(
                        "Screenshots",
                        url::get(array(\swdf::$app->name, "screenshot.show_v1_0", ""), array(), ""),
                        array("class" => "text-padding")
                    ),
                    array()
                ) . "\n" .
                html::tag(
                    "ul",
                    html::inline_tag("li", "Use bootstrap.", array()) . "\n" .
                    html::inline_tag("li", "Somewhat first version.", array()) . "\n" .
                    html::mono_tag("br", array()),
                    array()
                ) . "\n\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()),
                array()
            ),
            array()
        );

    }

    public function set_text()
    {
         $this->text = "About page.";
    }
}
?>
