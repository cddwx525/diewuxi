#!/bin/sh

# Description:
#   List files in directory recursively, one file per line, full path.
#   usage: recursive_list.sh {DIRECTORY}
#
# Author:
#   FENG Jianchao fjc-525@qq.com
#
# Date:
#   2017-07-08      done

set -o errexit

directory="${1}"

syntax_check ()
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
            syntax_check
            cd ..
        else
            local state="0"
            php -l "${file}" 2> /dev/null 1>&2 || state="1"
            if test "${state}" != "0"
            then
                echo "[${base_pathname}]"
                php -l "${file}" || true
                echo ""
            fi
        fi
    done
}

#
# Parameter check
#

if test "${#}" != "1"
then
    echo "Useage: ""$(basename "${0}")"": {directory}"
    exit
fi

if test ! -e "${directory}"
then
    echo "\"""${directory}""\" ""does not exit."
    exit
fi


cd "${directory}"

directory_pathname="$(pwd)"
directory_filename="$(basename "${directory_pathname}")"
base="${directory_pathname%/"${directory_filename}"}"

syntax_check
