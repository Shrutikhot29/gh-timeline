#!/bin/bash
CRON_CMD="*/5 * * * * /usr/bin/php $(pwd)/cron.php"
( crontab -l 2>/dev/null | grep -v -F "$CRON_CMD"; echo "$CRON_CMD" ) | crontab -
echo "CRON job installed to run every 5 minutes."