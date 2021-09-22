## Описание

phpDoc не используется с целью повысить читаемость, за исключением случаев когда type hinting не может обеспечить ясность. 

Немного от себя добавил в вымышленный сервис:
- Для post и put, сервис возвращает объект комментария в json. 
- Для get, сервис вернет массив комментариев в json.

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

При инъекции CommentsProvider в другие сервисы предполагается использовать интерфейс `src/Services/CommentProviderInterface.php` для инверсии зависимости

Использование в качестве пакета
```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/ernesttsenre/task2"
    }
  ],
  "require": {
    "oivanov/task2": "dev-master"
  }
}
```

## Запуск

```bash
# Сборка
composer install
```

```bash
# Тесты
./vendor/bin/phpunit tests
```
