Установка и запуск
1. Клонировать репозиторий

```bash
git clone https://github.com/allayar27/image-store-service.git
```

2. Установить зависимости

```bash
composer install
```

3. Настроить .env

Скопировать файл окружения:

```bash
cp .env.example .env
```

Сгенерировать ключ приложения:

```bash
php artisan key:generate
```

Миграции и сидеры

Запустить миграции:

```bash
php artisan migrate
```

Запуск сервера и воркера для очереди

```bash
php artisan serve

php artisan queue:work --queue=images
```

Приложение будет доступно по адресу:

```bash
http://127.0.0.1:8000
```

API Маршруты 

роут регистраций и логина:

```bash
http://127.0.0.1:8000/api/register

http://127.0.0.1:8000/api/login
```

закрытый апи роут для получение списка изображений текущего авторизованного пользователя:

```bash
GET  http://127.0.0.1:8000/api/images
```

закрытый апи роут для получение конкретного изображения:

```bash
GET  http://127.0.0.1:8000/api/images/{image}
```

закрытый апи роут для загрузки изображения:

```bash
POST  http://127.0.0.1:8000/api/images
```

закрытый апи роут для удаления изображения:

```bash
DELETE  http://127.0.0.1:8000/api/images/{images}
```

закрытый апи роут для выхода:

```bash
POST  http://127.0.0.1:8000/api/logout
```

