<?php
namespace Models;
use Db\Database;
use PDO;
class Item
{
    public function create($data)
    {
        $query = Database::connect()->prepare('INSERT INTO lorem_data (content) VALUES (:content)');
        $query->execute($data);
        return Database::connect()->lastInsertId();
    }
    public function getAll()
    {
        $query = Database::connect()->query('SELECT * FROM lorem_data');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get($id)
    {
        $query = Database::connect()->prepare('SELECT * FROM lorem_data WHERE id = :id');
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id, $data)
    {
        $query = Database::connect()->prepare('UPDATE lorem_data SET content = :content WHERE id = :id');
        $data['id'] = $id;
        $query->execute($data);
        return $id;
    }
    public function delete($id)
    {
        $query = Database::connect()->prepare('DELETE FROM lorem_data WHERE id = :id');
        $query->execute(['id' => $id]);
        return $query->rowCount() > 0;
    }
}