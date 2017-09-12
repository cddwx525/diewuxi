#!/bin/sh

set -o errexit

app="${1}"
processer="${2}"
controller_base="$(echo ${3} | sed -e "s/\//\\\\/g")"
#view_base="$(echo ${4} | tr "/" "\\")"
view_base="$(echo ${4} | sed -e "s/\//\\\\/g")"


cd "htdocs/apps/""${app}"

if test "${processer%/*}" = "${processer}"
then
    sub_directory=""
    processer_file_name="${processer}"
else
    #sub_directory="\\""$(echo ${processer%/*} | tr "/" "\\")"
    sub_directory="\\""$(echo ${processer%/*} | sed -e "s/\//\\\\/g")"
    processer_file_name="${processer##*/}"
    mkdir -p "controllers/""${processer%/*}"
    mkdir -p "views/""${processer%/*}"
fi

cat > controllers/${processer}.php << END
<?php
namespace ${app}\\controllers${sub_directory};

use ${app}\\lib\\controllers\\${controller_base} as base;

class ${processer_file_name} extends base
{
    public function operate(\$parameters)
    {
        /*
         * Some operation.
         */

        return array(
            "view_name" => \$view_name,
            "state" => "Y",
            "parameters" => \$parameters,
        );
    }
}
?>
END

cat > views/${processer}.php << END
<?php
namespace ${app}\\views${sub_directory};

use ${app}\\lib\\url;
use ${app}\\lib\\views\\${view_base} as base;

class ${processer_file_name} extends base
{
    public function get_items(\$result)
    {
        \$url = new url();

        \$parameters = \$result["parameters"];


        \$title = "";

        \$main = "<div id=\\"main\\" class=\\"border_frame\\">" . "\\n" . \$content . "\\n" . "</div>";

        return array(
            "title" => \$title,
            "main" => \$main,
        );
    }
}
?>
END
