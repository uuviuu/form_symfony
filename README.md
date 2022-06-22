<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://camo.githubusercontent.com/5f629ca13dac6ce46fb0ba69780cf8480f753143d768a99750716bd75ed01c4a/68747470733a2f2f73796d666f6e792e636f6d2f6c6f676f732f73796d666f6e795f626c61636b5f30322e737667" width="400"></a></p>

## About project

В данном проекте я изучаю фреймворк Symfony, планирую реализовать CRUD для создания постов

Для упрощения развертывания проекта предусмотрены такие технологии как GIT, Composer и Docker

Установка предполагает, что у вас уже установлен и настроен Docker, и присутсвует среда разработки Ubuntu-22.04

## Installation

Подготовьте рабочее простанство для развертывания проекта:

- создайте папку projects в каталоге //wsl$/Ubuntu-22.04/home/имя_пользователя/projects

- в данную папку установите репозиторий командой git clone https://github.com/uuviuu/form_symfony 

Для установки данного проекта введите команды:

- docker-compose up -d - установить зависимости из файла docker-compose.yml, переименуйте поля container_name, если они уже используются, если возникнет ошибка занятости порта, то измените порты nginx и db, оставив значения после двоеточия

- sudo chmod 777 -R ./ - передача прав пользователя проекту (попросит пароль пользователя)

- docker exec -it form_symfony_app bash - войти в контейнер

- composer update - установка библиотек PHP

- composer dump-autoload - включение классов, которые используются в проекте

Контакты: 
 - [почта](mailto:my.test.laravel.message@gmail.com) 
 - [telegram](https://t.me/uuviuu)
