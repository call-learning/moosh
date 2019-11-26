#!/bin/bash
source functions.sh

install_db
install_data

cd $MOODLEDIR

RESULT = $($MOOSHCMD check-needsupgrade)

if $RESULT == '1'; then
  exit 0
fi


# Set the version to few years from now
echo "UPDATE mdl_config SET version='2024123108' WHERE name='version'\G" | mysql -u "$DBUSER" -p"$DBPASSWORD" "$DBNAME"

RESULT = $($MOOSHCMD check-needsupgrade)

if $RESULT == '0'; then
  exit 0
fi

exit 1
