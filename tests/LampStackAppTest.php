<?php

use PHPUnit\Framework\TestCase;

class LampStackAppTest extends TestCase
{
    public function testDisplayLoremData()
    {
        ob_start();
        include 'index.php';
        $output = ob_get_clean();

        // Assert that the SQL output contains the HTML structure
        $this->assertStringContainsString('<h1>Lorem Ipsum Data</h1>', $output);
        $this->assertStringContainsString('<p>', $output);
    }
}

