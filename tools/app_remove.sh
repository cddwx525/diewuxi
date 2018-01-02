#!/bin/sh

set -o errexit

app="${1}"

rm -r "htdocs/apps/${app}"
