#!/bin/sh

set -o errexit

from="${1}"
to="${2}"

replace_string.sh "^namespace ${from}" "namespace ${to}" "htdocs/apps/${from}"
replace_string.sh "^use ${from}\\\\" "use ${to}\\\\" "htdocs/apps/${from}"
mv "htdocs/apps/${from}" "htdocs/apps/${to}"
