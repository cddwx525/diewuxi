#! /bin/sh

# Description:
#
# Depend:
#     dirname, readlink
#
# Author:
#     FENG Jian-Chao <fjc-525@qq.com>
#
# History:
#     2018-01-24

set -e # errexit. Exit when error.
#set -n # noexit. Read commands but do not execute them, check syntax.
#set -x # xtrace. Write command to stand error before excute, debugging.
#set -v # verbose. Write input to stand error, debugging.

LC_ALL=C
#LC_ALL=en_US.UTF-8
export LC_ALL

current_dir="$(dirname "$(readlink -f "${0}")")"

echo "HOME: $HOME"
echo "tidle:" ~/tmp
echo "current dir: $current_dir"
