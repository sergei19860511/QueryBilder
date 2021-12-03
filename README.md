## Использование
### Инициализируем объект класса QueryBilder и в конструктор передаём объект класса PDO
```
    $pdo = new QueryBilder(new PDO(...));
```
## Далее пользуемся методами QueryBilder
```
$pdo->getAll('users') //получить всех пользователей
```
```
$pdo->update('users', $_POST, $id)