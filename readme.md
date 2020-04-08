ControlTime - Приложение для учета посещаемости сотрудников
-----

#### Порядок установки и запуска

   > скачать репозиторий на локальную машину
   
   > перейти в папку проекта

   > выполнить команду
> 
>  `composer install`

   > выполнить команду
> 
> `php artisan project-install`

   > выполнить команду (запустить сервер Laravel)
> 
> `php artisan serve --port=8888`

   > перейти в папку "vue-control-time"

   > выполнить команду
>
> `yarn install`

   > выполнить команду (запустить сервер)
>
> `yarn serve`

## Установка и запуск под докером
- sh docker-project-install.sh
- Открыть http://localhost:8085

## Команды проекта под докером
* Проверка версий установленных пакетов: <br/>
    `sh docker-check-versions-packages.sh`
    
* Сборка фронта: <br/>
    `sh docker-yarn-build.sh`
    
* Сборка зависимостей бэка: <br/>
    `sh docker-composer-install.sh`

## Команды докера
- docker-compose up -d
- docker exec -it <имя или id контейнера> <shell>
- docker exec -it <имя или id контейнера> bash
- docker exec -it d18a28c93660 bash
- docker ps
- docker stop $(docker ps -a -q)
- docker rm $(docker ps -a -q) --force
- docker system prune
