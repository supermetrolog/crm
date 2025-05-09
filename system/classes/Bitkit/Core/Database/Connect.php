<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 29.09.2018
 * Time: 10:17
 */
namespace Bitkit\Core\Database;
class Connect extends \Bitkit\Core\Patterns\Singleton
{
    private $pdo;

    public function getConnection() : \PDO
    {
        if (!$this->pdo) {
            $this->pdo = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("set names utf8");
        }
        return $this->pdo;
    }

}     