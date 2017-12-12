#!/usr/bin/env bash
rsync -rav -e ssh  ./ root@121.43.113.130:/var/www/html/takeseat/ --exclude .git