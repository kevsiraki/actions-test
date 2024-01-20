<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vendor/autoload.php';
use Models\Item;

class ApiTest extends TestCase
{
    public function testCreate()
    {
        $data = ['content' => 'Test Content'];
        $id = Item::create($data);


        $this->assertIsString($id);
        $this->assertNotEmpty($id);
    }

    public function testGetAll()
    {
        $items = Item::getAll();

        // Assuming the result is an array
        $this->assertIsArray($items);

        foreach ($items as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('content', $item);
        }
    }

    public function testGet()
    {
        // Assuming there is at least one item in the database
        $existingItem = Item::getAll()[0];
        $id = $existingItem['id'];

        $item = Item::get($id);

        // Assuming the result is an array and has the same 'id' as the existing item
        $this->assertIsArray($item);
        $this->assertEquals($id, $item['id']);
    }

    public function testUpdate()
    {
        // Assuming there is at least one item in the database
        $existingItem = Item::getAll()[0];
        $id = $existingItem['id'];

        $data = ['content' => 'Updated Content'];
        Item::update($id, $data);

        // Fetch the item again after the update
        $updatedItem = Item::get($id);

        // Assuming the content has been updated
        $this->assertEquals($data['content'], $updatedItem['content']);
    }

    public function testDelete()
    {
        // Assuming there is at least one item in the database
        $existingItem = Item::getAll()[0];
        $id = $existingItem['id'];

        $success = Item::delete($id);

        // Assuming the delete operation was successful
        $this->assertTrue($success);
    }
}

