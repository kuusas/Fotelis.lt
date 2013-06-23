<?php
namespace Armchair;

use Doctrine\DBAL\Connection;
use PDO;

class CommentModel
{
    const SALT_START = 'pasūdytas';
    const SALT_END = 'papipirintas';

    protected $conn;

    public function __construct(Connection $conn) 
    {
        $this->conn = $conn;
    }

    public function getCommentHash(array $data)
    {
        return md5(self::SALT_START . sha1($data['id']) . self::SALT_END);
    }

    public function getByHash($hash)
    {
        $query = "SELECT * FROM `comment` WHERE MD5(CONCAT('" . self::SALT_START . "', SHA1(id), '" . self::SALT_END . "')) = :hash";
        $statement = $this->conn->executeQuery($query, array(
            'hash' => $hash
        ));

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByReference($reference)
    {
        $query = "SELECT * FROM `comment` WHERE reference = :reference AND status='active' ORDER BY date_created ASC";
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