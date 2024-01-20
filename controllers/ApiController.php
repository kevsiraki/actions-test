<?php
namespace Controllers;
require_once __DIR__ . '/../vendor/autoload.php';
use Models\Item;
error_reporting(E_ALL);
ini_set('display_errors', 1);
class ApiController
{
    public function handleRequest($method, $params)
    {
        switch ($method) {
            case 'GET':
                if ($params === 'items') {
                    $this->getAllItems();
                } elseif (preg_match('/items\/(\d+)/', $params, $matches)) {
                    $this->getItem($matches[1]);
                } else {
                    $this->defaultResponse();
                }
                break;

            case 'POST':
                if ($params === 'items') {
                    $jsonPayload = file_get_contents('php://input');
                    $data = json_decode($jsonPayload, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        $this->createItem($data);
                    } else {
                        $this->defaultResponse();
                    }
                } else {
                    $this->defaultResponse();
                }
                break;


            case 'PUT':
                if (preg_match('/items\/(\d+)/', $params, $matches)) {
                    $jsonPayload = file_get_contents('php://input');
                    $data = json_decode($jsonPayload, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        $this->updateItem($matches[1], $data);
                    } else {
                        $this->defaultResponse();
                    }
                } else {
                    $this->defaultResponse();
                }
                break;

            case 'DELETE':
                if (preg_match('/items\/(\d+)/', $params, $matches)) {
                    $this->deleteItem($matches[1]);
                } else {
                    $this->defaultResponse();
                }
                break;


            default:
                $this->defaultResponse();
                break;
        }
    }

    public function getAllItems()
    {
        $items = Item::getAll();
        echo json_encode($items);
    }

    public function getItem($id)
    {
        $item = Item::get($id);
        echo json_encode($item);
    }

    public function createItem($data)
    {
        $id = Item::create($data);
        echo json_encode(['id' => $id]);
    }

    public function updateItem($id, $data)
    {
        Item::update($id, $data);
        echo json_encode(['message' => 'Item updated successfully']);
    }

    public function defaultResponse()
    {
        echo json_encode(['message' => 'Invalid endpoint']);
    }

    public function deleteItem($id)
    {
        $success = Item::delete($id);

        if ($success) {
            echo json_encode(['message' => 'Item deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete item']);
        }
    }

}

// Get request method and URI
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Get the path without query parameters
$path = parse_url($requestUri, PHP_URL_PATH);
$parts = explode('/', trim($path, '/'));

// Keep only the first two parts
$filteredParts = array_slice($parts, 4, 5);

// Reconstruct the path
$filteredPath = implode('/', $filteredParts);

// Instantiate the ApiController and handle the request
$apiController = new ApiController();
$apiController->handleRequest($requestMethod, $filteredPath);
