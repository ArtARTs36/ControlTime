#!/usr/bin/env bash

# sh docker-project-install.sh

echo "
cd ControlTime

cp .env.docker.example .env

composer install
php artisan project-install

cd vue-control-time
yarn
yarn build
" | docker exec -i ControlTime-php-fpm bash
