<?php

// ApiController.php

namespace Controllers;

use Routing\Router;
use Models\Item;

class ApiController
{
    /** @var Router */
    private $router;

    /** @var Item */
    private $itemModel;

    /**
     * ApiController constructor.
     *
     * @param Router $router
     * @param Item $itemModel
     */
    public function __construct(Router $router, Item $itemModel)
    {
        $this->router = $router;
        $this->itemModel = $itemModel;
    }

    /**
     * Handle incoming requests based on the specified method and parameters.
     *
     * @param string $method
     * @param mixed $params
     */
    public function handleRequest($method, $params)
    {
        // Find the appropriate handler for the given method and parameters
        $handler = $this->router->findHandler($method, $params);

        // If a valid handler is found, execute it; otherwise, provide a default response
        if ($handler !== null) {
            $this->$handler($params);
        } else {
            $this->defaultResponse();
        }
    }

    /**
     * Retrieve all items and respond with a JSON-encoded representation.
     */
    public function getAllItems()
    {
        $items = $this->itemModel->getAll();
        echo json_encode($items);
    }

    /**
     * Retrieve a specific item by ID and respond with a JSON-encoded representation.
     *
     * @param mixed $params
     */
    public function getItem($params)
    {
        // Extract the ID from the URL parameters
        $parts = explode('/', $params);
        $id = end($parts);
        $id = is_numeric($id) ? (int) $id : null;

        // If a valid ID is found, retrieve the item and respond with JSON; otherwise, provide a default response
        if ($id !== null) {
            $item = $this->itemModel->get($id);
            echo json_encode($item);
        } else {
            $this->defaultResponse();
        }
    }

    /**
     * Create a new item based on the JSON payload received in the request.
     */
    public function createItem()
    {
        // Retrieve JSON payload from the request
        $jsonPayload = file_get_contents('php://input');
        $data = json_decode($jsonPayload, true);

        // If JSON decoding fails, respond with a Bad Request error
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        // Create a new item and respond with the generated ID
        $id = $this->itemModel->create($data);
        echo json_encode(['id' => $id]);
    }

    /**
     * Update an existing item with the provided data and respond with a success message.
     *
     * @param mixed $params
     */
    public function updateItem($params)
    {
        // Extract the ID from the URL parameters
        $parts = explode('/', $params);
        $id = end($parts);
        $id = is_numeric($id) ? (int) $id : null;

        // Retrieve JSON payload from the request
        $jsonPayload = file_get_contents('php://input');
        $data = json_decode($jsonPayload, true);

        // If JSON decoding fails, respond with a Bad Request error
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        // Update the item and respond with a success message
        $this->itemModel->update($id, $data);
        echo json_encode(['message' => 'Item updated successfully']);
    }

    /**
     * Delete an item based on the provided ID and respond with success or failure messages.
     *
     * @param mixed $params
     */
    public function deleteItem($params)
    {
        // Extract the ID from the URL parameters
        $parts = explode('/', $params);
        $id = end($parts);
        $id = is_numeric($id) ? (int) $id : null;

        // Attempt to delete the item and respond accordingly
        $success = $this->itemModel->delete($id);

        if ($success) {
            echo json_encode(['message' => 'Item deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete item']);
        }
    }

    /**
     * Respond with a JSON-encoded message indicating an invalid endpoint.
     */
    public function defaultResponse()
    {
        echo json_encode(['message' => 'Invalid endpoint']);
    }
}
