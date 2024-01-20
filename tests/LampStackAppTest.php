<?php

use PHPUnit\Framework\TestCase;

class LampStackAppTest extends TestCase
{
    private static $envAvailable = true;

    public static function setUpBeforeClass(): void
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        try {
            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
            $dotenv->load();
        } catch (\Dotenv\Exception\InvalidPathException $e) {
            self::$envAvailable = false;
        }
    }

    public function testDisplayLoremData()
    {
        // Skip the test if .env is not available
        if (!self::$envAvailable) {
            $this->markTestSkipped('.env file not available');
        }

        ob_start();
        include 'index.php';
        $output = ob_get_clean();

        // Assert that the output contains the HTML structure
        $this->assertStringContainsString('<h1>Lorem Ipsum Data</h1>', $output);
        $this->assertStringContainsString('<p>', $output);
    }
}