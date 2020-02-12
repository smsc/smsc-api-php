#!/bin/sh

SEARCH_PATHS_MD='./tests/,./src/'

./vendor/bin/phpmd $SEARCH_PATHS_MD text resources/rules/phpmd.xml

exit $?
