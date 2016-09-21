#!/bin/sh
NAME="week-one"

docker run --name $NAME -p 80:80 -v "$(pwd)/www":/var/www/html -v "$(pwd)/etc/limits.conf":/etc/security/limits.conf:ro php:7.0-apache
touch www/access.csv
docker exec $NAME chmod 777 access.csv
