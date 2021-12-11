<?php

namespace database;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    private $pdo;
    private $queryFactory;

    public function __construct()
    {
        $config = require __DIR__. '/../settings.php';
        $this->pdo = Connection::makeDB($config['database']);
        $this->queryFactory = new QueryFactory('mysql', QueryFactory::COMMON);
    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @return array
     */
    public function getAll($table)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*']);
        $select->from($table);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @param $id 'ИДЕНТИФИКАТОР ЗАПИСИ'
     * @return array
     */
    public function getOne($table, $id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['title']);
        $select->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $result = $sth->fetch(PDO::FETCH_ASSOC);

    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @param $data 'МАССИВ ДАННЫХ'
     * @return void
     */

    public function create($table, $data)
    {
        $insert = $this->queryFactory->newInsert();
        $insert->into($table)
            ->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @param $data 'МАССИВ ДАННЫХ'
     * @param $id 'ИДЕНТИФИКАТОР ЗАПИСИ'
     * @return null
     */
    public function update($table, $data, $id)
    {
        $update = $this->queryFactory->newUpdate();
        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id')
            ->bindValue('id', $id);
        $sth = $this->pdo->prepare($update->getStatement());

        $sth->execute($update->getBindValues());
    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @param $id 'ИДЕНТИФИКАТОР ЗАПИСИ'
     * @return null
     */
    public function delete($table, $id)
    {
        $delete = $this->queryFactory->newDelete();

        $delete->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($delete->getStatement());

        $sth->execute($delete->getBindValues());
    }
}
