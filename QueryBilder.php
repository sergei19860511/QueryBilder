<?php

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @return array
     */
    public function getAll($table)
    {
        $sql = "SELECT * FROM {$table}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @param $id 'ИДЕНТИФИКАТОР ЗАПИСИ'
     * @return array
     */
    public function getOne($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        return $post;
    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @param $data 'МАССИВ ДАННЫХ'
     * @return null
     */

    public function create($table, $data)
    {
        $keys = implode(',', array_keys($data));
        $tags = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tags})";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @param $data 'МАССИВ ДАННЫХ'
     * @param $id 'ИДЕНТИФИКАТОР ЗАПИСИ'
     * @return null
     */
    public function update($table, $data, $id)
    {
        $keys = array_keys($data);
        $string = '';
        foreach ($keys as $key) {
            $string .= $key . '= :'. $key. ',';
        }
        $data['id'] = $id;
        $key = rtrim($string, ',');
        $sql = "UPDATE {$table} SET {$key} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

    }

    /**
     * @param $table 'НАЗВАНИЕ ТАБЛИЦЫ'
     * @param $id 'ИДЕНТИФИКАТОР ЗАПИСИ'
     * @return null
     */
    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
