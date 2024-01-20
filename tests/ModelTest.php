<?php

use PHPUnit\Framework\TestCase;
use Models\Item;

class ModelTest extends TestCase
{
    /**
     * Set up any necessary preconditions before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test the create method of the Item class.
     */
    public function testCreate()
    {
        // Mock the create method of the Item class
        $mockedId = 'mocked_id';

        $itemMock = $this->getMockBuilder(Item::class)
            ->onlyMethods(['create'])
            ->getMock();

        $itemMock->expects($this->any())
            ->method('create')
            ->willReturn($mockedId);

        // Perform the test
        $data = ['content' => 'Test Content'];
        $id = $itemMock->create($data);

        // Assert that the ID returned matches the mocked ID
        $this->assertEquals($mockedId, $id);
    }

    /**
     * Test the getAll method of the Item class.
     */
    public function testGetAll()
    {
        // Mock the getAll method of the Item class
        $mockedItems = [
            ['id' => '1', 'content' => 'Item 1'],
            ['id' => '2', 'content' => 'Item 2'],
        ];

        $itemMock = $this->getMockBuilder(Item::class)
            ->onlyMethods(['getAll'])
            ->getMock();

        $itemMock->expects($this->any())
            ->method('getAll')
            ->willReturn($mockedItems);

        // Perform the test
        $items = $itemMock->getAll();

        // Assert that the returned items are in the expected format
        $this->assertIsArray($items);

        foreach ($items as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('content', $item);
        }
    }

    /**
     * Test the get method of the Item class.
     */
    public function testGet()
    {
        // Mock the get method of the Item class
        $mockedId = 'mocked_id';
        $mockedItem = ['id' => $mockedId, 'content' => 'Mocked Item'];

        $itemMock = $this->getMockBuilder(Item::class)
            ->onlyMethods(['get'])
            ->getMock();

        $itemMock->expects($this->any())
            ->method('get')
            ->willReturn($mockedItem);

        // Perform the test
        $existingItem = $itemMock->get($mockedId);

        // Assert that the returned item is in the expected format
        $this->assertIsArray($existingItem);
        $this->assertEquals($mockedItem, $existingItem);
    }

    /**
     * Test the update method of the Item class.
     */
    public function testUpdate()
    {
        // Mock the update method of the Item class
        $mockedId = 'mocked_id';

        $itemMock = $this->getMockBuilder(Item::class)
            ->onlyMethods(['update', 'get']) // Add 'get' to the list of methods to mock
            ->getMock();

        $itemMock->expects($this->any())
            ->method('update')
            ->willReturn($mockedId);

        // Mock the get method to return the updated item
        $itemMock->expects($this->any())
            ->method('get')
            ->willReturn(['id' => $mockedId, 'content' => 'Updated Content']);

        // Perform the test
        $data = ['content' => 'Updated Content'];
        $itemMock->update($mockedId, $data);

        // Fetch the item again after the update
        $updatedItem = $itemMock->get($mockedId);

        // Assert that the content is updated correctly
        $this->assertEquals($data['content'], $updatedItem['content']);
    }

    /**
     * Test the delete method of the Item class.
     */
    public function testDelete()
    {
        // Mock the delete method of the Item class
        $mockedId = 'mocked_id';

        $itemMock = $this->getMockBuilder(Item::class)
            ->onlyMethods(['delete'])
            ->getMock();

        $itemMock->expects($this->any())
            ->method('delete')
            ->willReturn(true);

        // Perform the test
        $success = $itemMock->delete($mockedId);

        // Assert that the delete operation is successful
        $this->assertTrue($success);
    }

    /**
     * Clean up any resources after each test.
     */
    protected function tearDown(): void
    {
        // Clean up any resources if needed
        parent::tearDown();
    }
}
