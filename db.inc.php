<?php
// define('DBHOST', '176.119.254.176');
// define('DBNAME', 'web1221344_ticketSystem');
// define('DBUSER', 'web1221344_dbuser');
// define('DBPASS', 'E@323kRfnX');
// define('DBCONNSTRING',"mysql:host=". DBHOST. ";dbname=". DBNAME);

define('DBHOST', 'localhost');
define('DBNAME', 'tap');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBCONNSTRING', "mysql:host=" . DBHOST . ";dbname=" . DBNAME);

$db = new DatabaseHelper();

class DatabaseHelper
{
    private $pdo;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchOne($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function execute($sql, $params = [])
    {
        return $this->query($sql, $params);
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function getEnumValues(string $tableName, string $columnName): array
    {
        try {
            $query = "SELECT COLUMN_TYPE 
                      FROM information_schema.columns 
                      WHERE table_name = :table AND column_name = :column AND table_schema = DATABASE()";

            // Prepare and execute the statement
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':table' => $tableName,
                ':column' => $columnName,
            ]);

            $columnType = $stmt->fetchColumn();

            if ($columnType) {
                $columnType = trim($columnType, "enum()");
                $columnType = str_replace("'", "", $columnType);
                return explode(',', $columnType);
            }

            return [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function disconnect()
    {
        $this->pdo = null;
    }
}
?>