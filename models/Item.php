<?php

// Item.php

namespace Models;

use Db\Database;
use PDO;

class Item
{
    /**
     * Create a new item in the database.
     *
     * @param array $data The data to be inserted into the database.
     *
     * @return int The ID of the last inserted item.
     * @throws \Exception If an error occurs during the database transaction.
     */
    public function create($data)
    {
        $db = Database::connect();
        $db->beginTransaction();

        try {
            $query = $db->prepare('INSERT INTO lorem_data (content) VALUES (:content)');
            $query->execute($data);
            $lastInsertId = $db->lastInsertId();
            $db->commit();
            return $lastInsertId;
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /**
     * Retrieve all items from the database.
     *
     * @return array The list of items as associative arrays.
     */
    public function getAll()
    {
        $query = Database::connect()->query('SELECT * FROM lorem_data');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieve a specific item by ID from the database.
     *
     * @param int $id The ID of the item to retrieve.
     *
     * @return array|null The item as an associative array or null if not found.
     */
    public function get($id)
    {
        $query = Database::connect()->prepare('SELECT * FROM lorem_data WHERE id = :id');
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update an existing item in the database.
     *
     * @param int $id The ID of the item to update.
     * @param array $data The data to update the item with.
     *
     * @return int The ID of the updated item.
     * @throws \Exception If an error occurs during the database transaction.
     */
    public function update($id, $data)
    {
        $db = Database::connect();
        $db->beginTransaction();

        try {
            $query = $db->prepare('UPDATE lorem_data SET content = :content WHERE id = :id');
            $data['id'] = $id;
            $query->execute($data);
            $db->commit();
            return $id;
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /**
     * Delete an item from the database.
     *
     * @param int $id The ID of the item to delete.
     *
     * @return bool True if the item is successfully deleted, false otherwise.
     * @throws \Exception If an error occurs during the database transaction.
     */
    public function delete($id)
    {
        $db = Database::connect();
        $db->beginTransaction();

        try {
            $query = $db->prepare('DELETE FROM lorem_data WHERE id = :id');
            $query->execute(['id' => $id]);
            $rowCount = $query->rowCount();
            $db->commit();
            return $rowCount > 0;
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
}
