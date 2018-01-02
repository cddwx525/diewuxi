#!/bin/sh

# Description:
#   搜索一个目录中所有文本文件中中的特定模式
#
# Author:
#   FENG Jianchao fjc-525@qq.com
#
# Date:
#   2017-07-08      Set directory to a variable, default to diary directory.
#   2017-02-01      Use cd to generate short filename.
#   2015-05-27      done
#
# TODO:         截取一个块a

set -o errexit

DIARY=~/documents/1-diary

PATTERN="${1}"
DIRECTORY="${2:-${DIARY}}"

OPTION="--color=always \
        --with-filename \
        --line-number \
        --initial-tab \
        --recursive \
        --ignore-case \
        --basic-regexp"

if test "${#}" -ne "1" -a "${#}" -ne "2"
then
    echo "Useage: ""$(basename "${0}")"" {pattern} [directory = DIARY]"
    exit
fi

cd "${DIRECTORY}"
grep ${OPTION} --regexp="${PATTERN}" * | sort --general-numeric-sort
