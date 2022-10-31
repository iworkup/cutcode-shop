## Первичная установка одной командой

`php artisan shop:install` - включает в себя:

- `php artisan storage:link`
- `php artisan migrate`
- make .env and .env.testing from .env.example

## Доп настройка

- Добавить `FILESYSTEM_DISK=public` в .env

