## Описание

Немного от себя добавил в сервис:
- Для post и put сервис возвращает объект комментария в json. 
- Для get сервис вернет массив комментариев в json.

Использование в реальном коде предполагается такое:
```php
$client = new Client(['base_uri' => 'http://example.com']);
$apiClient = new ApiClient($client);

$commentValidator = new CommentValidator();
$commentFactory = new CommentFactory($commentValidator);

$provider = new CommentsProvider($apiClient, $commentFactory);

// получить все комментарии
$provider->get();

// создать комментарий
$provider->create(new Comment(...));

// обновить комментарий
$provider->update(new Comment(...));
```

```bash
# Сборка
composer install
```

```bash
# Тесты
./vendor/bin/phpunit tests
```