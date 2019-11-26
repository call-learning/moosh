#!/bin/bash
source functions.sh

install_db
install_data

cd $MOODLEDIR

$MOOSHCMD plug force-version "mod_chat" "2000010100"
if echo "SELECT * FROM mdl_config_plugins WHERE plugin='mod_chat' AND name ='version' and value '2000010100'\G" \
    | mysql -u "$DBUSER" -p"$DBPASSWORD" "$DBNAME" | grep "name: debug"; then
  exit 0
else
 exit 1
fi

