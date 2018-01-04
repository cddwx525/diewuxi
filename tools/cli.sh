#!/bin/sh

set -o errexit
#set -x
#set -v

controller="${1}"
action="${2}"
parameters="${3}"

site="http://localhost:8888"
url="${site}""/doc/admin/""${controller}""?action=${action}""${parameters}"
user_agent="Mozilla/5.0 (X11; Linux x86_64; rv:56.0) Gecko/20100101 Firefox/56.0"

__test="0a3dc94762f4db7d59d9748da94d9f30"
name="simpleblog"
serial="9e4f2bf744e2d2677ded960e7b7ca3c67802c2501e1540463db15a49f61a7113"
stamp="f26b9275882f205fdbff13f90bfcf85752521a687bbe74f893e43ee149337002"
PHPSESSID="6926279f10aed0590f543f1d1d836364"
cookies="__test=${__test}; name=${name}; serial=${serial}; stamp=${stamp}; PHPSESSID=${PHPSESSID};"

curl -L --user-agent "${user_agent}" -b "${cookies}" "${url}"
