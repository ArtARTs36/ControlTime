#!/usr/bin/env bash

# sh docker-project-install.sh

cp .env.docker.example .env

CURRENT_FOLDER=pwd|tr / "\n"|tail -1
CURRENT_FOLDER_LOWER_CASE=CURRENT_FOLDER| tr '[:upper:]' '[:lower:]'
DOCKER_NETWORK_NAME="${CURRENT_FOLDER_LOWER_CASE}_testing_get"

docker network create $DOCKER_NETWORK_NAME

docker-compose build

docker-compose up -d

echo "
cd ControlTime

composer install
php artisan project-install

cd vue-control-time
yarn
yarn build
" | docker exec -i ControlTime-php-fpm bash
