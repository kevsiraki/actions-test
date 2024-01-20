<?php

namespace Db;

use Dotenv\Dotenv;
use PDO;

class Database
{
    /** @var PDO|null The static instance of the PDO connection */
    private static $connection;

    /**
     * Establish a PDO database connection.
     *
     * @return PDO The PDO database connection instance.
     */
    public static function connect()
    {
        // Check if the connection has not been established
        if (!self::$connection) {
            // Load environment variables from the .env file in the root directory
            $dotenv = Dotenv::createImmutable(__DIR__.'/..'); // Assuming the .env file is in the root directory
            $dotenv->load();            

            // Retrieve database configuration from environment variables
            $dbHost = $_ENV['DB_HOST'];
            $dbName = $_ENV['DB_NAME'];
            $dbUser = $_ENV['DB_USER'];
            $dbPass = $_ENV['DB_PASSWORD'];

            // Establish a new PDO connection
            self::$connection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            
            // Set PDO attributes for error reporting and exceptions
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$connection;
    }
}
