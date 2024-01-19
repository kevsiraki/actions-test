<?php

use PHPUnit\Framework\TestCase;

class LoremDataTest extends TestCase
{
    private static $conn;

    public static function setUpBeforeClass(): void
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        self::$conn = new mysqli(
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            $_ENV['DB_NAME']
        );

        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::$conn->close();
    }

    public function testDisplayLoremData()
    {
        // You can insert test data here if needed

        ob_start();
        include 'index.php';
        $output = ob_get_clean();

        // Assert that the output contains the HTML structure
        $this->assertStringContainsString('<h1>Lorem Ipsum Data</h1>', $output);
        $this->assertStringContainsString('<p>', $output);

        // You can add more specific assertions based on your actual data or use case
    }
}

