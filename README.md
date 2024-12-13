## Стэк

- PHP 8.2
- postgreSQL 16

## Запуск проекта

1. Копирование .env на настройка
    ```
    cp .env.example .env
    ```
2. Запуск docker 
    ```
    docker-composer up -d
    ```
3. Вход в контейнер
    ```
    docker exec -it php fish
    ```
4. Установка зависимостей 
    ```
    composer install
    ```
5. Генерация ключа
    ```
    php artisan key:generate
    ```
6. Запуск миграций
    ```
    php artisan migrate
    ```

## Работа с проектом
# Pint
Для форматирования кода используется команда композера
```
composer pint
```
Или по старинке
```
./vendor/bin/pint
```

# PHPStan
Для проверки кода используется команда композера
```
composer analyse
```
Или по старинке
```
./vendor/bin/phpstan analyse
```
