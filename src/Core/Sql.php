<?php

namespace App\Core;

use Dotenv\Dotenv;

class Sql
{
    private static $instance = null;
    protected $pdo;

    protected function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];

        $this->pdo = new \PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $this->pdo->exec('SET NAMES UTF8');
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Sql();
        }

        return self::$instance;
    }

    public function query($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }

    public static function testConnection()
    {
        $sql = Sql::getInstance();
        return $sql->query('SHOW TABLES')->fetchAll();
    }
}
