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
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
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

    public function disconnect()
    {
        $this->pdo = null;
    }
}
?>