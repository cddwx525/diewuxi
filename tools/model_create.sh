#!/bin/sh

set -o errexit

app="${1}"
model="${2}"


cd "htdocs/apps/""${app}"

cat > models/${model}.php << END
<?php
namespace ${app}\\models;

use ${app}\lib\\db_hander;

class ${model} extends db_hander
{
    public $table_name = "${model}";
}
?>
END
