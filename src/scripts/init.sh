#!/bin/bash

echo "ok" > /var/www/health.html

php /var/www/artisan optimize:clear

systemctl reload httpd.service

cd /var/www/
/usr/local/bin/composer install
