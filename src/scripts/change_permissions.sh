#!/bin/bash
setfacl -Rdn -m group:apache:rwx /var/www/storage
setfacl -Rn -m group:apache:rwx /var/www/storage

setfacl -Rdn -m group:apache:rwx /var/www/bootstrap/cache
setfacl -Rn -m group:apache:rwx /var/www/bootstrap/cache

chmod -R 777 /var/www/storage
chmod -R 777 /var/www/bootstrap/cache
