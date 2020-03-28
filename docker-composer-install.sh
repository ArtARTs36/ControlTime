#!/usr/bin/env bash

# sh docker-composer-install.sh

echo "
cd ControlTime
composer install
" | docker exec -i ControlTime-php-fpm bash
