#!/bin/bash

# Standards / validity checking
phpcs --standard=PSR2 -n **/*.php
if [ $? -ne 0 ]; then
    echo "phpcs checks failed!"
    exit 1
fi

eslint js
if [ $? -ne 0 ]; then
    echo "eslint checks failed!"
    exit 1
fi

jshint js
if [ $? -ne 0 ]; then
    echo "jshint checks failed!"
    exit 1
fi

# Try actually running files to check for any errors.
# This will really only work for actions that don't require
# a user to be logged in.
PHPFILES=`ls *.php js/*.php`

# If an old log exists, make room for a new
PHPLOG="private/log/error.log"
if [ -e "$PHPLOG" ]
then
  TIMESTAMP=`date +%Y%m%d`
  NEWLOGFILE=$PHPLOG.$TIMESTAMP
  mv $PHPLOG $NEWLOGFILE
fi

for f in $PHPFILES
do
  # Don't check cron.php
  if [ "$f" != "cron.php" ]
  then
    echo "Executing file $f"
    php "$f" > /dev/null 2>&1
    if [ $? -ne 0 ]; then
      echo "Running file $f has failed! File output: "
      php "$f"
      exit 1
    fi
  fi
done

if [ -e "$PHPLOG" ]
then
  echo "Errors exist!"
  cat "$PHPLOG"
  exit 1
fi

echo "No errrors logged."

exit 0
