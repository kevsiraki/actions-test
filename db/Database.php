<?php
namespace Db;
use Dotenv\Dotenv;
use PDO;

class Database
{
    private static $connection;

    public static function connect()
    {
        if (!self::$connection) {
            $dotenv = Dotenv::createImmutable(__DIR__.'/..'); // Assuming the .env file is in the root directory
            $dotenv->load();            

            $dbHost = $_ENV['DB_HOST'];
            $dbName = $_ENV['DB_NAME'];
            $dbUser = $_ENV['DB_USER'];
            $dbPass = $_ENV['DB_PASSWORD'];


            self::$connection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$connection;
    }
}