<?php
require_once "config.php";
class Database
{
    private $pdo;
    private static $db;

    private function __construct()
    {
        $options = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $options);
        } catch (PDOException $e) {
            echo "Ошибка подключения к БД " . $e->getMessage();
        }
    }

    public static function getDBO() //созд метода для получения экз подключения
    {
        if (!self::$db) { //если экз класса отсутствует то создаем
            self::$db = new Database();
        }
        return self::$db;
    }

    public function getCountRows(string $table_name, string $where = '', array $values = []): int //выводит кол-во строк
    {
        $sql = 'SELECT COUNT(`id`) as `count` FROM ' . $this->getTableName($table_name);
        if ($where) $sql .= " WHERE $where";
        $query = $this->pdo->prepare($sql);
        $query->execute($values);
        return $query->fetchColumn();
    }
    public function getTableName(string $table_name): string //формируем имя таблицы
    {
        return '`' . DB_PREFIX . $table_name . '`';
    }
    public function getRows(string $table_name, string $where = '', array $values = [], string $order_by = '') //выводит все строки
    {
        $sql = 'SELECT * FROM ' . $this->getTableName($table_name);
        if ($where) $sql .= " WHERE $where";
        if ($order_by) {
            $sql .= " ORDER BY `$order_by`";
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($values);
        return $query->fetchAll();
    }
    public function getRowByWhere(string $table_name, string $where, array $values = []): array //выводит 1 строку по выборке where
    {
        $sql = 'SELECT * FROM ' . $this->getTableName($table_name) . " WHERE $where";
        $query = $this->pdo->prepare($sql);
        $query->execute($values);
        $result = $query->fetch();
        if ($result) {
            return $result;
        }
        return [];
    }
    public function getRowById(string $table_name, int $id): array //выводит 1 строку по id
    {
        return $this->getRowByWhere($table_name, '`id`=?', [$id]);
    }
    public function getRowsByIds(string $table_name, array $ids): array //выводит несколько строк по  их id
    {
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $sql = 'SELECT * FROM ' . $this->getTableName($table_name) . " WHERE `id` IN ($in)";
        $query = $this->pdo->prepare($sql);
        $query->execute($ids);
        $result = [];
        //return $query->fetchAll(); но лучше сделать, чтобы ключом(индексом) был id выбранной строки
        foreach ($query->fetchAll() as $row) {
            $result[$row['id']] = $row;
        }
        return $result;
    }
    //Изменение -- UPDATE `secret_grinvich` SET `title` = 'Рим2' WHERE `secret_grinvich`.`id` = 7
    public function update(string $table_name, array $fields,  array $values, string $where = '', array $where_values = []) //обновление строки
    {
        $sql = 'UPDATE ' . $this->getTableName($table_name) . ' SET';
        foreach ($fields as $field) {
            $sql .= "`$field` = ?,";
        }
        $sql = substr($sql, 0, -1); //убираем лишнюю запятую
        if ($where) $sql .= " WHERE $where";
        $query = $this->pdo->prepare($sql);
        $query->execute(array_merge($values, $where_values));
    }
    ///вывод 1 столбца(column) в массив,индексы будут Id
    public function getDateFromColomn(string $table_name, string $column_name): array
    {
        $sql = 'SELECT id,' . $column_name . ' FROM ' . $this->getTableName($table_name);
        $query = $this->pdo->query($sql);
        $row = $query->fetchALL(PDO::FETCH_KEY_PAIR);
        $result = $row;
        return $result;
    }

    public function insert(string $table_name, array $fields,  array $values) //добавление строки
    {
        $sql = 'INSERT INTO ' . $this->getTableName($table_name) . ' (';
        foreach ($fields as $field) {
            $sql .= "`$field`,";
        }
        $sql = substr($sql, 0, -1); //убираем лишнюю запятую
        $sql .= ") VALUES (";
        foreach ($values as $val) {
            $sql .= "'$val',";
        }
        $sql = substr($sql, 0, -1); //убираем лишнюю запятую
        $sql .= ')';
        $query = $this->pdo->exec($sql);
    }
    //Удаление --DELETE FROM blog_comments WHERE `blog_comments`.`id` = 3"
    public function delete(string $table_name, int $id) //удаление строки
    {
        $sql = 'DELETE FROM ' . $this->getTableName($table_name) . ' WHERE ' . $this->getTableName($table_name) . ".`id`= ?";

        $query = $this->pdo->prepare($sql);
        $query->execute([$id]);
    }
    //закрываем подключение
    public function __destruct()
    {
        $this->pdo = null;
    }
}
//$p = new Database();
//$p->getTableName("users");
//$p->delete('comments', 5);
//echo '<pre>';
//print_r($p->getDateFromColomn('article', 'date'));
