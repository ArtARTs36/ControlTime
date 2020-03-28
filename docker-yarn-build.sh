#!/usr/bin/env bash

# sh docker-yarn-build.sh

echo "
cd ControlTime/vue-control-time
yarn
yarn build
" | docker exec -i ControlTime-php-fpm bash
