<?php
return array(
    /*
     * Guest controllers.
     */
    array(
        "^$",
        array(""),
        array(""),
        array("blog", "common", "guest/home", "show", "", array()),
        array("blog", "guest/home.show", "",),
    ),
    array(
        "^/$",
        array("/"),
        array(""),
        array("blog", "common", "guest/home", "show", "", array()),
        array("blog", "", "/",),
    ),
    array(
        "^/about\.html$",
        array("/about.html"),
        array(""),
        array("blog", "common", "guest/about", "show", "", array()),
        array("blog", "guest/about.show", "",),
    ),

    array(
        "^/articles\.html$",
        array("/articles.html"),
        array(""),
        array("blog", "common", "guest/article", "list_all", "", array()),
        array("blog", "guest/article.list_all", "",),
    ),

    array(
        "^/categories\.html$",
        array("/categories.html"),
        array(""),
        array("blog", "common", "guest/category", "list_all", "", array(),),
        array("blog", "guest/category.list_all", "",),
    ),
    array(
        "^/categories/(?P<full_slug>([[:word:]-]+/)*[[:word:]-]+)\.html$",
        array("/categories/", ".html"),
        array("full_slug", ""),
        array("blog", "common", "guest/category", "slug_show", "", array(),),
        array("blog", "guest/category.slug_show", "",),
    ),

    array(
        "^/tags\.html$",
        array("/tags.html"),
        array(""),
        array("blog", "common", "guest/tag", "list_all", "", array(),),
        array("blog", "guest/tag.list_all", "",),
    ),
    array(
        "^/tags/(?P<slug>[[:word:]-]+)\.html$",
        array("/tags/", ".html"),
        array("slug", ""),
        array("blog", "common", "guest/tag", "slug_show", "", array(),),
        array("blog", "guest/tag.slug_show", "",),
    ),

    array(
        "^/by-tag/(?P<tag_slug>[[:word:]-]+)$",
        array("/by-tag/",),
        array("tag_slug",),
        array("blog", "common", "guest/article", "slug_list_by_tag", "", array()),
        array("blog", "guest/article.slug_list_by_tag", "",),
    ),
    array(
        "^/articles/(?P<full_category_slug>([[:word:]-]+/)*[[:word:]-]+)/index\.html$",
        array("/articles/", "/index.html"),
        array("full_category_slug", ""),
        array("blog", "common", "guest/article", "slug_list_by_category", "", array()),
        array("blog", "guest/article.slug_list_by_category", "",),
    ),
    array(
        "^/articles/(?P<full_slug>([[:word:]-]+/)+[[:word:]-]+)\.html$",
        array("/articles/", ".html"),
        array("full_slug", ""),
        array("blog", "common", "guest/article", "slug_show", "", array()),
        array("blog", "guest/article.slug_show", "",),
    ),

    array(
        "^/comments\?action=write&article_id=(?P<article_id>\d+)&target_id=(?P<target_id>\w+)$",
        array("/comments?action=write&article_id=", "&target_id="),
        array("article_id", "target_id"),
        array("blog", "common", "guest/comment", "write", "", array(),),
        array("blog", "guest/comment.write", "",),
    ),
    array(
        "^/comments\?action=add$",
        array("/comments?action=add"),
        array(""),
        array("blog", "common", "guest/comment", "add", "", array(),),
        array("blog", "guest/comment.add", "",),
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
                array("blog", "common", "admin/home", "show", "", array()),
                array("blog", "admin/home.show", "",),
            ),
            array(
                "^/$",
                array("/"),
                array(""),
                array("blog", "", "", "", "301", array("blog", "admin/home.show", "",),),
                array("blog", "", "/",),
            ),

            //
            // Authentication
            //
            array(
                "^/authentication\?action=write$",
                array("/authentication?action=write"),
                array(""),
                array("blog", "common", "admin/authentication", "write", "", array()),
                array("blog", "admin/authentication.write", "",),
            ),
            array(
                "^/authentication\?action=login$",
                array("/authentication?action=login"),
                array(""),
                array("blog", "common", "admin/authentication", "login", "", array()),
                array("blog", "admin/authentication.login", "",),
            ),
            array(
                "^/authentication\?action=logout$",
                array("/authentication?action=logout"),
                array(""),
                array("blog", "common", "admin/authentication", "logout", "", array()),
                array("blog", "admin/authentication.logout", "",),
            ),

            //
            // Settings
            //
            array(
                "^/settings\?action=show$",
                array("/settings?action=show"),
                array(""),
                array("blog", "common", "admin/settings", "show", "", array()),
                array("blog", "admin/settings.show", "",),
            ),

            //
            // Config
            //
            array(
                "^/config\?action=write$",
                array("/config?action=write"),
                array(""),
                array("blog", "common", "admin/config", "write", "", array()),
                array("blog", "admin/config.write", "",),
            ),
            array(
                "^/config\?action=save$",
                array("/config?action=save"),
                array(""),
                array("blog", "common", "admin/config", "save", "", array()),
                array("blog", "admin/config.save", "",),
            ),

            //
            // Option
            //
            array(
                "^/option\?action=edit$",
                array("/option?action=edit"),
                array(""),
                array("blog", "common", "admin/option", "edit", "", array()),
                array("blog", "admin/option.edit", "",),
            ),
            array(
                "^/option\?action=update$",
                array("/option?action=update"),
                array(""),
                array("blog", "common", "admin/option", "update", "", array()),
                array("blog", "admin/option.update", "",),
            ),

            //
            // Account
            //
            array(
                "^/account\?action=edit$",
                array("/account?action=edit"),
                array(""),
                array("blog", "common", "admin/account", "edit", "", array()),
                array("blog", "admin/account.edit", "",),
            ),
            array(
                "^/account\?action=update$",
                array("/account?action=update"),
                array(""),
                array("blog", "common", "admin/account", "update", "", array()),
                array("blog", "admin/account.update", "",),
            ),

            //
            // Articles
            //
            array(
                "^/articles\?action=list_all$",
                array("/articles?action=list_all"),
                array(""),
                array("blog", "common", "admin/article", "list_all", "", array()),
                array("blog", "admin/article.list_all", "",),
            ),
            array(
                "^/articles\?action=list_by_category&category_id=(?P<category_id>\d+)$",
                array("/articles?action=list_by_category&category_id=",),
                array("category_id",),
                array("blog", "common", "admin/article", "list_by_category", "", array()),
                array("blog", "admin/article.list_by_category", "",),
            ),
            array(
                "^/articles\?action=list_by_tag&tag_id=(?P<tag_id>\d+)$",
                array("/articles?action=list_by_tag&tag_id=",),
                array("tag_id",),
                array("blog", "common", "admin/article", "list_by_tag", "", array()),
                array("blog", "admin/article.list_by_tag", "",),
            ),
            array(
                "^/articles\?action=list_by_file&file_id=(?P<file_id>\d+)$",
                array("/articles?action=list_by_file&file_id=",),
                array("file_id",),
                array("blog", "common", "admin/article", "list_by_file", "", array()),
                array("blog", "admin/article.list_by_file", "",),
            ),
            array(
                "^/articles\?action=show&id=(?P<id>\d+)$",
                array("/articles?action=show&id=",),
                array("id",),
                array("blog", "common", "admin/article", "show", "", array()),
                array("blog", "admin/article.show", "",),
            ),
            array(
                "^/articles\?action=write$",
                array("/articles?action=write"),
                array(""),
                array("blog", "common", "admin/article", "write", "", array()),
                array("blog", "admin/article.write", "",),
            ),
            array(
                "^/articles\?action=add$",
                array("/articles?action=add"),
                array(""),
                array("blog", "common", "admin/article", "add", "", array()),
                array("blog", "admin/article.add", "",),
            ),
            array(
                "^/articles\?action=edit&id=(?P<id>\d+)$",
                array("/articles?action=edit&id="),
                array("id"),
                array("blog", "common", "admin/article", "edit", "", array()),
                array("blog", "admin/article.edit", "",),
            ),
            array(
                "^/articles\?action=update$",
                array("/articles?action=update"),
                array(""),
                array("blog", "common", "admin/article", "update", "", array()),
                array("blog", "admin/article.update", "",),
            ),
            array(
                "^/articles\?action=delete_confirm&id=(?P<id>\d+)$",
                array("/articles?action=delete_confirm&id="),
                array("id"),
                array("blog", "common", "admin/article", "delete_confirm", "", array()),
                array("blog", "admin/article.delete_confirm", "",),
            ),
            array(
                "^/articles\?action=delete$",
                array("/articles?action=delete"),
                array(""),
                array("blog", "common", "admin/article", "delete", "", array()),
                array("blog", "admin/article.delete", "",),
            ),

            //
            // Categories
            //
            array(
                "^/categories\?action=list_all$",
                array("/categories?action=list_all"),
                array(""),
                array("blog", "common", "admin/category", "list_all", "", array(),),
                array("blog", "admin/category.list_all", "",),
            ),
            array(
                "^/categories\?action=show&id=(?P<id>\d+)$",
                array("/categories?action=show&id=",),
                array("id",),
                array("blog", "common", "admin/category", "show", "", array(),),
                array("blog", "admin/category.show", "",),
            ),
            array(
                "^/categories\?action=write$",
                array("/categories?action=write"),
                array(""),
                array("blog", "common", "admin/category", "write", "", array(),),
                array("blog", "admin/category.write", "",),
            ),
            array(
                "^/categories\?action=add$",
                array("/categories?action=add"),
                array(""),
                array("blog", "common", "admin/category", "add", "", array(),),
                array("blog", "admin/category.add", "",),
            ),
            array(
                "^/categories\?action=edit\?id=(?P<id>\d+)$",
                array("/categories?action=edit?id="),
                array("id"),
                array("blog", "common", "admin/category", "edit", "", array(),),
                array("blog", "admin/category.edit", "",),
            ),
            array(
                "^/categories\?action=update$",
                array("/categories?action=update"),
                array(""),
                array("blog", "common", "admin/category", "update", "", array(),),
                array("blog", "admin/category.update", "",),
            ),
            array(
                "^/categories\?action=delete_confirm&id=(?P<id>\d+)$",
                array("/categories?action=delete_confirm&id="),
                array("id"),
                array("blog", "common", "admin/category", "delete_confirm", "", array(),),
                array("blog", "admin/category.delete_confirm", "",),
            ),
            array(
                "^/categories\?action=delete$",
                array("/categories?action=delete"),
                array(""),
                array("blog", "common", "admin/category", "delete", "", array(),),
                array("blog", "admin/category.delete", "",),
            ),

            //
            // Tags
            //
            array(
                "^/tags\?action=list_all$",
                array("/tags?action=list_all"),
                array(""),
                array("blog", "common", "admin/tag", "list_all", "", array(),),
                array("blog", "admin/tag.list_all", "",),
            ),
            array(
                "^/tags\?action=show&id=(?P<id>\d+)$",
                array("/tags?action=show&id=",),
                array("id",),
                array("blog", "common", "admin/tag", "show", "", array(),),
                array("blog", "admin/tag.show", "",),
            ),
            array(
                "^/tags\?action=write$",
                array("/tags?action=write"),
                array(""),
                array("blog", "common", "admin/tag", "write", "", array(),),
                array("blog", "admin/tag.write", "",),
            ),
            array(
                "^/tags\?action=add$",
                array("/tags?action=add"),
                array(""),
                array("blog", "common", "admin/tag", "add", "", array(),),
                array("blog", "admin/tag.add", "",),
            ),
            array(
                "^/tags\?action=edit\?id=(?P<id>\d+)$",
                array("/tags?action=edit?id="),
                array("id"),
                array("blog", "common", "admin/tag", "edit", "", array(),),
                array("blog", "admin/tag.edit", "",),
            ),
            array(
                "^/tags\?action=update$",
                array("/tags?action=update"),
                array(""),
                array("blog", "common", "admin/tag", "update", "", array(),),
                array("blog", "admin/tag.update", "",),
            ),
            array(
                "^/tags\?action=delete_confirm&id=(?P<id>\d+)$",
                array("/tags?action=delete_confirm&id="),
                array("id"),
                array("blog", "common", "admin/tag", "delete_confirm", "", array(),),
                array("blog", "admin/tag.delete_confirm", "",),
            ),
            array(
                "^/tags\?action=delete$",
                array("/tags?action=delete"),
                array(""),
                array("blog", "common", "admin/tag", "delete", "", array(),),
                array("blog", "admin/tag.delete", "",),
            ),

            //
            // Files
            //
            array(
                "^/files\?action=list_all$",
                array("/files?action=list_all"),
                array(""),
                array("blog", "common", "admin/file", "list_all", "", array(),),
                array("blog", "admin/file.list_all", "",),
            ),
            array(
                "^/files\?action=list_by_article&article_id=(?P<article_id>\d+)$",
                array("/files?action=list_by_article&article_id="),
                array("article_id"),
                array("blog", "common", "admin/file", "list_by_article", "", array(),),
                array("blog", "admin/file.list_by_article", "",),
            ),
            array(
                "^/files\?action=show&id=(?P<id>\d+)$",
                array("/files?action=show&id=",),
                array("id",),
                array("blog", "common", "admin/file", "show", "", array(),),
                array("blog", "admin/file.show", "",),
            ),
            array(
                "^/files\?action=write$",
                array("/files?action=write"),
                array(""),
                array("blog", "common", "admin/file", "write", "", array(),),
                array("blog", "admin/file.write", "",),
            ),
            array(
                "^/files\?action=add$",
                array("/files?action=add"),
                array(""),
                array("blog", "common", "admin/file", "add", "", array(),),
                array("blog", "admin/file.add", "",),
            ),
            array(
                "^/files\?action=edit\?id=(?P<id>\d+)$",
                array("/files?action=edit?id="),
                array("id"),
                array("blog", "common", "admin/file", "edit", "", array(),),
                array("blog", "admin/file.edit", "",),
            ),
            array(
                "^/files\?action=update$",
                array("/files?action=update"),
                array(""),
                array("blog", "common", "admin/file", "update", "", array(),),
                array("blog", "admin/file.update", "",),
            ),
            array(
                "^/files\?action=delete_confirm&id=(?P<id>\d+)$",
                array("/files?action=delete_confirm&id="),
                array("id"),
                array("blog", "common", "admin/file", "delete_confirm", "", array(),),
                array("blog", "admin/file.delete_confirm", "",),
            ),
            array(
                "^/files\?action=delete$",
                array("/files?action=delete"),
                array(""),
                array("blog", "common", "admin/file", "delete", "", array(),),
                array("blog", "admin/file.delete", "",),
            ),

            //
            // Comments
            //
            array(
                "^/comments\?action=list_all$",
                array("/comments?action=list_all"),
                array(""),
                array("blog", "common", "admin/comment", "list_all", "", array(),),
                array("blog", "admin/comment.list_all", "",),
            ),
            array(
                "^/comments\?action=list_by_article\?article_id=(?P<article_id>\d+)$",
                array("/comments?action=list_by_article?article_id="),
                array("article_id"),
                array("blog", "common", "admin/comment", "list_by_article", "", array(),),
                array("blog", "admin/comment.list_by_article", "",),
            ),
            array(
                "^/comments\?action=write&article_id=(?P<article_id>\d+)&target_id=(?P<target_id>\w+)$",
                array("/comments?action=write&article_id=", "&target_id="),
                array("article_id", "target_id"),
                array("blog", "common", "admin/comment", "write", "", array(),),
                array("blog", "admin/comment.write", "",),
            ),
            array(
                "^/comments\?action=add$",
                array("/comments?action=add"),
                array(""),
                array("blog", "common", "admin/comment", "add", "", array(),),
                array("blog", "admin/comment.add", "",),
            ),
            array(
                "^/comments\?action=delete_confirm&id=(?P<id>\d+)$",
                array("/comments?action=delete_confirm&id="),
                array("id"),
                array("blog", "common", "admin/comment", "delete_confirm", "", array(),),
                array("blog", "admin/comment.delete_confirm", "",),
            ),
            array(
                "^/comments\?action=delete$",
                array("/comments?action=delete"),
                array(""),
                array("blog", "common", "admin/comment", "delete", "", array(),),
                array("blog", "admin/comment.delete", "",),
            ),

            /*
             * Text mode
             */
            array(
                "^/articles\?mode=text&action=list_category&category_id=(?P<category_id>\d+)$",
                array("/articles?mode=text&action=list_category&category_id=",),
                array("category_id",),
                array("blog", "common", "admin/article", "list_category", "text", array()),
                array("blog", "admin/article.list_by_category", "text",),
            ),

            array(
                "^/comments\?mode=text&action=list_all$",
                array("/comments?mode=text&action=list_all"),
                array(""),
                array("blog", "common", "admin/comment", "list_all", "text", array(),),
                array("blog", "admin/comment.list_all", "text",),
            ),
        ),
    ),
);
?>
