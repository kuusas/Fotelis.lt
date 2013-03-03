<?php
namespace Armchair;

use Doctrine\DBAL\Connection;
use PDO;

class CommentModel
{
    protected $conn;

    public function __construct(Connection $conn) 
    {
        $this->conn = $conn;
    }

    public function getAllByReference($reference)
    {
        $query = "SELECT * FROM `comment` WHERE reference = :reference ORDER BY date_created ASC";
        $statement = $this->conn->executeQuery($query, array(
            'reference' => $reference
        ));

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM `comment` WHERE id = :id";
        $statement = $this->conn->executeQuery($query, array(
            'id' => $id
        ));

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $data, $id)
    {
        $result = $this->conn->update('`comment`', $data, array('id' => $id));

        return $result;
    }

    public function insert(array $data)
    {
        $result = false;

        if ($this->conn->insert('`comment`', $data)) {
            $result = $this->conn->lastInsertId();
        }

        return $result;
    }
}