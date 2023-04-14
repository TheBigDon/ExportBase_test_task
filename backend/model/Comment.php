<?php

class Comment {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findByImageId($id)
    {
        $statement = "SELECT * FROM comments WHERE id_image = ?;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Array $input) 
    {
        $statement = "INSERT INTO comments(user, text_comment, date_comment, id_image)
                      VALUES(:user, :text_comment, now(), :id_image);";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'user' => $input['user'],
                'text_comment' => $input['text_comment'],
                'id_image' => $input['id_image'],
            ));
            return $statement->rowCount();
        } catch (PDOException $e){
            exit($e->getMessage());
        }
    }

    public function delete($id) 
    {
        $statement = "DELETE FROM comments WHERE id = :id;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (PDOException $e){
            exit($e->getMessage());
        }
    }
}

?>