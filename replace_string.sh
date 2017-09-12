#!/bin/bash

# Description:
#   sed 前端, 替换字符串
#   SOURCE, TARGET 是正则表达式匹配模式, 作为参数传递给脚本, 需要引用.
#   ALLFILE 是 shell 展开模式, 作为参数传递给脚本, 需要引用.
#
#   例如:
#   script_name.sh "xxxx" "BLOGNAME" "admin/*.php include/*.php ./*.php"
#   更复杂的例子，注意引用的方法，其结果要符合 sed 的正则表达式
#   replace_string.sh "require(\$_SERVER\['DOCUMENT_ROOT'\] \. '\/include\/site_define\.php');" "require \$_SERVER\['DOCUMENT_ROOT'\] \. \\\"\/include\/site_define\.php\\\";" "htdocs/*.php htdocs/admin/*.php"
#
# Author:
#   FENG Jianchao <fjc-525@qq.com>
#
# Changelog:
#   2017-07-19
#       recursive in directory.
#   2017-03-20  Test parameter, test file.
#   2015-11-01

set -e

original="${1}"
target="${2}"
directory="${3}"

replace ()
{
    for file in ./*
    do
        if test ! -e "${file}"
        then
            continue
        fi

        local current="$(pwd)"
        local base_pathname="${current#"${base}"}""/""${file#./}"

        if test -d "${file}"
        then
            cd "${file}"
            replace
            cd ..
        elif test -f "${file}"
        then
            echo "Replacing in file: \"""${base_pathname}""\" ..."
            sed --posix --in-place --expression="s/${original}/${target}/g" "${file}"
        fi
    done
}


if test "${#}" -ne 3
then
    echo "Useage: ""$(basename ${0})"": {original} {target} {directory}"
    exit
fi

if test ! -e "${directory}"
then
    echo "\"""${directory}""\" ""does not exit."
    exit
fi


echo "Source pattern: ${original}"
echo "Target pattern: ${target}"
echo "These pattern right?(y/n)"
read confirm

if test "${confirm}" != "y"
then
    echo "Exit."
    exit
fi


cd "${directory}"

directory_pathname="$(pwd)"
directory_filename="$(basename "${directory_pathname}")"
base="${directory_pathname%/"${directory_filename}"}"

replace
