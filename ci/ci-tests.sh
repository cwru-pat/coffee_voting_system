#!/bin/bash

# Hit a php pages and check for any errors.
# This will only work for actions that don't require 
# a user to be logged in.
PHPFILES=`ls *.php js/*.php`

for f in $PHPFILES
do
  echo "Executing file $f"
  php "$f" > /dev/null 2>&1
done

PHPLOG="private/log/error.log"
if [ -e "$PHPLOG" ]
then
  echo "Errors exist!"
  cat "$PHPLOG"
  exit 1
fi

exit 0
