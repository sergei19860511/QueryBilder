# Использование
## Теперь класс зависит от пакета aura/sqlquery, v 2.7.1 
## установить пакет можно по [ссылке](https://packagist.org/packages/aura/sqlquery)

### Инициализируем объект класса QueryBilder
```
    $pdo = new QueryBilder();
```
## Далее пользуемся методами QueryBilder
```
$pdo->getAll('users') //получить всех пользователей
```
```
$pdo->update('users', $_POST, $id)