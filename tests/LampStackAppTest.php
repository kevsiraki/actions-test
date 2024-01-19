<?php

use PHPUnit\Framework\TestCase;

class LampStackAppTest extends TestCase
{
    public function testHomePage()
    {
        ob_start();
        include 'index.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('<h1>Hello, LAMP Stack!</h1>', $output);
        $this->assertStringContainsString('<p>This is a simple LAMP stack app without MySQL connections.</p>', $output);
    }
}
