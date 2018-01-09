<?php
namespace blog;

use blog\app_setting;

class urls
{
    public function url_map()
    {
        $app_name = app_setting::APP_SPACE_NAME;

        $url_map = array(
            /*
             * Guest controllers.
             */
            array(
                "^$",
                array(""),
                array(""),
                array($app_name, "", "", "", "301", array($app_name, "", "/",),),
                array($app_name, "", "",),
            ),
            array(
                "^/$",
                array("/"),
                array(""),
                array($app_name, "", "", "", "301", array($app_name, "guest/home.show", "",),),
                array($app_name, "", "/",),
            ),
            array(
                "^/home$",
                array("/home"),
                array(""),
                array($app_name, "COMMON", "guest/home", "show", "", ""),
                array($app_name, "guest/home.show", "",),
            ),
            array(
                "^/about$",
                array("/about"),
                array(""),
                array($app_name, "COMMON", "guest/about", "show", "", ""),
                array($app_name, "guest/about.show", "",),
            ),

            array(
                "^/articles/all$",
                array("/articles/all"),
                array(""),
                array($app_name, "COMMON", "guest/article", "list_all", "", ""),
                array($app_name, "guest/article.list_all", "",),
            ),
            array(
                "^/articles/collect/tag/(?P<tag_slug>[[:word:]-]+)$",
                array("/articles/collect/tag/",),
                array("tag_slug",),
                array($app_name, "COMMON", "guest/article", "slug_list_tag", "", ""),
                array($app_name, "guest/article.slug_list_tag", "",),
            ),
            //array(
            //    "^/articles\?category_id=(?P<category_id>\d+)$",
            //    array("/articles?category_id=",),
            //    array("category_id",),
            //    array($app_name, "COMMON", "guest/article", "list_category", "", ""),
            //    array($app_name, "guest/article.list_category", "",),
            //),
            array(
                "^/articles/(?P<full_category_slug>([[:word:]-]+/)+)all$",
                array("/articles/", "all"),
                array("full_category_slug", ""),
                array($app_name, "COMMON", "guest/article", "slug_list", "", ""),
                array($app_name, "guest/article.slug_list", "",),
            ),
            //array(
            //    "^/article/(?P<id>\d+)$",
            //    array("/article/",),
            //    array("id",),
            //    array($app_name, "COMMON", "guest/article", "show", "", ""),
            //    array($app_name, "guest/article.show", "",),
            //),
            array(
                "^/articles/(?P<full_article_slug>([[:word:]-]+/)+[[:word:]-]+)$",
                array("/articles/",),
                array("full_article_slug", ""),
                array($app_name, "COMMON", "guest/article", "slug_show", "", ""),
                array($app_name, "guest/article.slug_show", "",),
            ),


            array(
                "^/categories/all$",
                array("/categories/all"),
                array(""),
                array($app_name, "COMMON", "guest/category", "list_all", "", "",),
                array($app_name, "guest/category.list_all", "",),
            ),
            //array(
            //    "^/categories/(?P<id>\d+)$",
            //    array("/categories/",),
            //    array("id",),
            //    array($app_name, "COMMON", "guest/category", "show", "", "",),
            //    array($app_name, "guest/category.show", "",),
            //),
            array(
                "^/categories/(?P<category_slug>[[:word:]-]+)$",
                array("/categories/",),
                array("category_slug",),
                array($app_name, "COMMON", "guest/category", "slug_show", "", "",),
                array($app_name, "guest/category.slug_show", "",),
            ),

            array(
                "^/tags/all$",
                array("/tags/all"),
                array(""),
                array($app_name, "COMMON", "guest/tag", "list_all", "", "",),
                array($app_name, "guest/tag.list_all", "",),
            ),
            //array(
            //    "^/tags/(?P<id>\d+)$",
            //    array("/tags/",),
            //    array("id",),
            //    array($app_name, "COMMON", "guest/tag", "show", "", "",),
            //    array($app_name, "guest/tag.show", "",),
            //),
            array(
                "^/tags/(?P<tag_slug>[[:word:]-]+)$",
                array("/tags/",),
                array("tag_slug",),
                array($app_name, "COMMON", "guest/tag", "slug_show", "", "",),
                array($app_name, "guest/tag.slug_show", "",),
            ),

            array(
                "^/comments\?action=write&article_id=(?P<article_id>\d+)&target_id=(?P<target_id>\w+)$",
                array("/comments?action=write&article_id=", "&target_id="),
                array("article_id", "target_id"),
                array($app_name, "COMMON", "guest/comment", "write", "", "",),
                array($app_name, "guest/comment.write", "",),
            ),
            array(
                "^/comments\?action=add$",
                array("/comments?action=add"),
                array(""),
                array($app_name, "COMMON", "guest/comment", "add", "", "",),
                array($app_name, "guest/comment.add", "",),
            ),


            /*
             * Administrator controllers.
             */
            array(
                "^/admin",
                array("/admin"),
                array(""),
                array(
                    array(
                        "^$",
                        array(""),
                        array(""),
                        array($app_name, "", "", "", "301", array($app_name, "admin/home.show", "",),),
                        array($app_name, "", "",),
                    ),
                    array(
                        "^/$",
                        array("/"),
                        array(""),
                        array($app_name, "", "", "", "301", array($app_name, "admin/home.show", "",),),
                        array($app_name, "", "/",),
                    ),
                    array(
                        "^/home\?action=show$",
                        array("/home?action=show"),
                        array(""),
                        array($app_name, "COMMON", "admin/home", "show", "", ""),
                        array($app_name, "admin/home.show", "",),
                    ),

                    array(
                        "^/authentication\?action=write$",
                        array("/authentication?action=write"),
                        array(""),
                        array($app_name, "COMMON", "admin/authentication", "write", "", ""),
                        array($app_name, "admin/authentication.write", "",),
                    ),
                    array(
                        "^/authentication\?action=login$",
                        array("/authentication?action=login"),
                        array(""),
                        array($app_name, "COMMON", "admin/authentication", "login", "", ""),
                        array($app_name, "admin/authentication.login", "",),
                    ),
                    array(
                        "^/authentication\?action=logout$",
                        array("/authentication?action=logout"),
                        array(""),
                        array($app_name, "COMMON", "admin/authentication", "logout", "", ""),
                        array($app_name, "admin/authentication.logout", "",),
                    ),

                    array(
                        "^/settings\?action=show$",
                        array("/settings?action=show"),
                        array(""),
                        array($app_name, "COMMON", "admin/settings", "show", "", ""),
                        array($app_name, "admin/settings.show", "",),
                    ),

                    array(
                        "^/config\?action=write$",
                        array("/config?action=write"),
                        array(""),
                        array($app_name, "COMMON", "admin/config", "write", "", ""),
                        array($app_name, "admin/config.write", "",),
                    ),
                    array(
                        "^/config\?action=save$",
                        array("/config?action=save"),
                        array(""),
                        array($app_name, "COMMON", "admin/config", "save", "", ""),
                        array($app_name, "admin/config.save", "",),
                    ),

                    array(
                        "^/option\?action=edit$",
                        array("/option?action=edit"),
                        array(""),
                        array($app_name, "COMMON", "admin/option", "edit", "", ""),
                        array($app_name, "admin/option.edit", "",),
                    ),
                    array(
                        "^/option\?action=update$",
                        array("/option?action=update"),
                        array(""),
                        array($app_name, "COMMON", "admin/option", "update", "", ""),
                        array($app_name, "admin/option.update", "",),
                    ),

                    array(
                        "^/account\?action=edit$",
                        array("/account?action=edit"),
                        array(""),
                        array($app_name, "COMMON", "admin/account", "edit", "", ""),
                        array($app_name, "admin/account.edit", "",),
                    ),
                    array(
                        "^/account\?action=update$",
                        array("/account?action=update"),
                        array(""),
                        array($app_name, "COMMON", "admin/account", "update", "", ""),
                        array($app_name, "admin/account.update", "",),
                    ),

                    array(
                        "^/articles\?action=list_all$",
                        array("/articles?action=list_all"),
                        array(""),
                        array($app_name, "COMMON", "admin/article", "list_all", "", ""),
                        array($app_name, "admin/article.list_all", "",),
                    ),
                    array(
                        "^/articles\?action=list_category&category_id=(?P<category_id>\d+)$",
                        array("/articles?action=list_category&category_id=",),
                        array("category_id",),
                        array($app_name, "COMMON", "admin/article", "list_category", "", ""),
                        array($app_name, "admin/article.list_category", "",),
                    ),
                    array(
                        "^/articles\?action=list_tag&tag_id=(?P<tag_id>\d+)$",
                        array("/articles?action=list_tag&tag_id=",),
                        array("tag_id",),
                        array($app_name, "COMMON", "admin/article", "list_tag", "", ""),
                        array($app_name, "admin/article.list_tag", "",),
                    ),
                    array(
                        "^/articles\?action=show&id=(?P<id>\d+)$",
                        array("/articles?action=show&id=",),
                        array("id",),
                        array($app_name, "COMMON", "admin/article", "show", "", ""),
                        array($app_name, "admin/article.show", "",),
                    ),
                    array(
                        "^/articles\?action=write$",
                        array("/articles?action=write"),
                        array(""),
                        array($app_name, "COMMON", "admin/article", "write", "", ""),
                        array($app_name, "admin/article.write", "",),
                    ),
                    array(
                        "^/articles\?action=add$",
                        array("/articles?action=add"),
                        array(""),
                        array($app_name, "COMMON", "admin/article", "add", "", ""),
                        array($app_name, "admin/article.add", "",),
                    ),
                    array(
                        "^/articles\?action=edit&id=(?P<id>\d+)$",
                        array("/articles?action=edit&id="),
                        array("id"),
                        array($app_name, "COMMON", "admin/article", "edit", "", ""),
                        array($app_name, "admin/article.edit", "",),
                    ),
                    array(
                        "^/articles\?action=update$",
                        array("/articles?action=update"),
                        array(""),
                        array($app_name, "COMMON", "admin/article", "update", "", ""),
                        array($app_name, "admin/article.update", "",),
                    ),
                    array(
                        "^/articles\?action=delete_confirm&id=(?P<id>\d+)$",
                        array("/articles?action=delete_confirm&id="),
                        array("id"),
                        array($app_name, "COMMON", "admin/article", "delete_confirm", "", ""),
                        array($app_name, "admin/article.delete_confirm", "",),
                    ),
                    array(
                        "^/articles\?action=delete$",
                        array("/articles?action=delete"),
                        array(""),
                        array($app_name, "COMMON", "admin/article", "delete", "", ""),
                        array($app_name, "admin/article.delete", "",),
                    ),

                    array(
                        "^/categories\?action=list_all$",
                        array("/categories?action=list_all"),
                        array(""),
                        array($app_name, "COMMON", "admin/category", "list_all", "", "",),
                        array($app_name, "admin/category.list_all", "",),
                    ),
                    array(
                        "^/categories\?action=show&id=(?P<id>\d+)$",
                        array("/categories?action=show&id=",),
                        array("id",),
                        array($app_name, "COMMON", "admin/category", "show", "", "",),
                        array($app_name, "admin/category.show", "",),
                    ),
                    array(
                        "^/categories\?action=write$",
                        array("/categories?action=write"),
                        array(""),
                        array($app_name, "COMMON", "admin/category", "write", "", "",),
                        array($app_name, "admin/category.write", "",),
                    ),
                    array(
                        "^/categories\?action=add$",
                        array("/categories?action=add"),
                        array(""),
                        array($app_name, "COMMON", "admin/category", "add", "", "",),
                        array($app_name, "admin/category.add", "",),
                    ),
                    array(
                        "^/categories\?action=edit\?id=(?P<id>\d+)$",
                        array("/categories?action=edit?id="),
                        array("id"),
                        array($app_name, "COMMON", "admin/category", "edit", "", "",),
                        array($app_name, "admin/category.edit", "",),
                    ),
                    array(
                        "^/categories\?action=update$",
                        array("/categories?action=update"),
                        array(""),
                        array($app_name, "COMMON", "admin/category", "update", "", "",),
                        array($app_name, "admin/category.update", "",),
                    ),
                    array(
                        "^/categories\?action=delete_confirm&id=(?P<id>\d+)$",
                        array("/categories?action=delete_confirm&id="),
                        array("id"),
                        array($app_name, "COMMON", "admin/category", "delete_confirm", "", "",),
                        array($app_name, "admin/category.delete_confirm", "",),
                    ),
                    array(
                        "^/categories\?action=delete$",
                        array("/categories?action=delete"),
                        array(""),
                        array($app_name, "COMMON", "admin/category", "delete", "", "",),
                        array($app_name, "admin/category.delete", "",),
                    ),

                    array(
                        "^/tags\?action=list_all$",
                        array("/tags?action=list_all"),
                        array(""),
                        array($app_name, "COMMON", "admin/tag", "list_all", "", "",),
                        array($app_name, "admin/tag.list_all", "",),
                    ),
                    array(
                        "^/tags\?action=show&id=(?P<id>\d+)$",
                        array("/tags?action=show&id=",),
                        array("id",),
                        array($app_name, "COMMON", "admin/tag", "show", "", "",),
                        array($app_name, "admin/tag.show", "",),
                    ),
                    array(
                        "^/tags\?action=write$",
                        array("/tags?action=write"),
                        array(""),
                        array($app_name, "COMMON", "admin/tag", "write", "", "",),
                        array($app_name, "admin/tag.write", "",),
                    ),
                    array(
                        "^/tags\?action=add$",
                        array("/tags?action=add"),
                        array(""),
                        array($app_name, "COMMON", "admin/tag", "add", "", "",),
                        array($app_name, "admin/tag.add", "",),
                    ),
                    array(
                        "^/tags\?action=edit\?id=(?P<id>\d+)$",
                        array("/tags?action=edit?id="),
                        array("id"),
                        array($app_name, "COMMON", "admin/tag", "edit", "", "",),
                        array($app_name, "admin/tag.edit", "",),
                    ),
                    array(
                        "^/tags\?action=update$",
                        array("/tags?action=update"),
                        array(""),
                        array($app_name, "COMMON", "admin/tag", "update", "", "",),
                        array($app_name, "admin/tag.update", "",),
                    ),
                    array(
                        "^/tags\?action=delete_confirm&id=(?P<id>\d+)$",
                        array("/tags?action=delete_confirm&id="),
                        array("id"),
                        array($app_name, "COMMON", "admin/tag", "delete_confirm", "", "",),
                        array($app_name, "admin/tag.delete_confirm", "",),
                    ),
                    array(
                        "^/tags\?action=delete$",
                        array("/tags?action=delete"),
                        array(""),
                        array($app_name, "COMMON", "admin/tag", "delete", "", "",),
                        array($app_name, "admin/tag.delete", "",),
                    ),

                    array(
                        "^/medias\?action=list_all$",
                        array("/medias?action=list_all"),
                        array(""),
                        array($app_name, "COMMON", "admin/media", "list_all", "", "",),
                        array($app_name, "admin/media.list_all", "",),
                    ),
                    array(
                        "^/medias\?action=list_article&article_id=(?P<article_id>\d+)$",
                        array("/medias?action=list_article&article_id="),
                        array("article_id"),
                        array($app_name, "COMMON", "admin/media", "list_article", "", "",),
                        array($app_name, "admin/media.list_article", "",),
                    ),
                    array(
                        "^/medias\?action=show&id=(?P<id>\d+)$",
                        array("/medias?action=show&id=",),
                        array("id",),
                        array($app_name, "COMMON", "admin/media", "show", "", "",),
                        array($app_name, "admin/media.show", "",),
                    ),
                    array(
                        "^/medias\?action=write$",
                        array("/medias?action=write"),
                        array(""),
                        array($app_name, "COMMON", "admin/media", "write", "", "",),
                        array($app_name, "admin/media.write", "",),
                    ),
                    array(
                        "^/medias\?action=add$",
                        array("/medias?action=add"),
                        array(""),
                        array($app_name, "COMMON", "admin/media", "add", "", "",),
                        array($app_name, "admin/media.add", "",),
                    ),
                    array(
                        "^/medias\?action=edit\?id=(?P<id>\d+)$",
                        array("/medias?action=edit?id="),
                        array("id"),
                        array($app_name, "COMMON", "admin/media", "edit", "", "",),
                        array($app_name, "admin/media.edit", "",),
                    ),
                    array(
                        "^/medias\?action=update$",
                        array("/medias?action=update"),
                        array(""),
                        array($app_name, "COMMON", "admin/media", "update", "", "",),
                        array($app_name, "admin/media.update", "",),
                    ),
                    array(
                        "^/medias\?action=delete_confirm&id=(?P<id>\d+)$",
                        array("/medias?action=delete_confirm&id="),
                        array("id"),
                        array($app_name, "COMMON", "admin/media", "delete_confirm", "", "",),
                        array($app_name, "admin/media.delete_confirm", "",),
                    ),
                    array(
                        "^/medias\?action=delete$",
                        array("/medias?action=delete"),
                        array(""),
                        array($app_name, "COMMON", "admin/media", "delete", "", "",),
                        array($app_name, "admin/media.delete", "",),
                    ),

                    array(
                        "^/comments\?action=list_all$",
                        array("/comments?action=list_all"),
                        array(""),
                        array($app_name, "COMMON", "admin/comment", "list_all", "", "",),
                        array($app_name, "admin/comment.list_all", "",),
                    ),
                    array(
                        "^/comments\?action=write&article_id=(?P<article_id>\d+)&target_id=(?P<target_id>\w+)$",
                        array("/comments?action=write&article_id=", "&target_id="),
                        array("article_id", "target_id"),
                        array($app_name, "COMMON", "admin/comment", "write", "", "",),
                        array($app_name, "admin/comment.write", "",),
                    ),
                    array(
                        "^/comments\?action=add$",
                        array("/comments?action=add"),
                        array(""),
                        array($app_name, "COMMON", "admin/comment", "add", "", "",),
                        array($app_name, "admin/comment.add", "",),
                    ),
                    array(
                        "^/comments\?action=delete_confirm&id=(?P<id>\d+)$",
                        array("/comments?action=delete_confirm&id="),
                        array("id"),
                        array($app_name, "COMMON", "admin/comment", "delete_confirm", "", "",),
                        array($app_name, "admin/comment.delete_confirm", "",),
                    ),
                    array(
                        "^/comments\?action=delete$",
                        array("/comments?action=delete"),
                        array(""),
                        array($app_name, "COMMON", "admin/comment", "delete", "", "",),
                        array($app_name, "admin/comment.delete", "",),
                    ),

                    /*
                     * Text mode
                     */
                    array(
                        "^/articles\?mode=text&action=list_category&category_id=(?P<category_id>\d+)$",
                        array("/articles?mode=text&action=list_category&category_id=",),
                        array("category_id",),
                        array($app_name, "COMMON", "admin/article", "list_category", "text", ""),
                        array($app_name, "admin/article.list_category", "text",),
                    ),

                    array(
                        "^/comments\?mode=text&action=list_all$",
                        array("/comments?mode=text&action=list_all"),
                        array(""),
                        array($app_name, "COMMON", "admin/comment", "list_all", "text", "",),
                        array($app_name, "admin/comment.list_all", "text",),
                    ),
                ),
            ),
        );

        return $url_map;
    }
}
?>
